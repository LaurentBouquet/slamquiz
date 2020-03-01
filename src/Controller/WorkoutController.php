<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Workout;
use App\Entity\Question;
use App\Form\WorkoutType;
use App\Form\QuestionType;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/workout")
 */
class WorkoutController extends AbstractController
{
    /**
     * @Route("/", name="workout_index", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('workout/index.html.twig', [
            'workouts' => $workoutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="workout_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $quizRepository = $em->getRepository(Quiz::class);
        $quiz = $quizRepository->findOneBy([
            'id' => $id
        ]);
      
        $workout = new Workout();
        $workout->setStartedAt(new \DateTime());
        $workout->setQuiz($quiz);
        $workout->setCurrentQuestionNumber(0);
        $workout->setCompleted(false);
        $em->persist($workout);
        $em->flush();

        return $this->render('workout/new.html.twig', [
            'workout' => $workout,
            'quiz' => $quiz,
            'progress' => ($workout->getCurrentQuestionNumber()/$quiz->getNumberOfQuestions())*100,
        ]);
    }

    /**
     * @Route("/{id}/next", name="workout_next", methods={"GET","POST"})
     */
    public function next(Request $request, Workout $workout, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $workout->setCurrentQuestionNumber($workout->getCurrentQuestionNumber()+1);  
        
        $quizRepository = $em->getRepository(Quiz::class);
        $quiz = $quizRepository->findOneBy([
            'id' => $workout->getQuiz()
        ]);
       
        $questionRepository = $em->getRepository(Question::class);
        $lastQuestion = $questionRepository->findOneById($workout->getLastQuestionId());
        $form = $this->createForm(QuestionType::class, $lastQuestion, array('form_type'=>'student_questioning'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lastAnswers = $lastQuestion->getAnswers();            
            foreach ($lastAnswers as $answer) {
                dump($answer);
            }                     
        }
        
        $nextQuestion = $questionRepository->findOneRandomByCategories($quiz->getCategories());
        $workout->setLastQuestionId($nextQuestion->getId());
        $form = $this->createForm(QuestionType::class, $nextQuestion, array('form_type'=>'student_questioning'));

        $em->persist($workout);
        $em->flush();      
        
        return $this->render('workout/workout.html.twig', [
            'workout' => $workout,
            'quiz' => $quiz,
            'progress' => ($workout->getCurrentQuestionNumber()/$quiz->getNumberOfQuestions())*100,
            'form' => $form->createView(),
        ]);
    }    

    /**
     * @Route("/{id}", name="workout_show", methods={"GET"})
     */
    public function show(Workout $workout): Response
    {
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="workout_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Workout $workout): Response
    {
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workout_index');
        }

        return $this->render('workout/edit.html.twig', [
            'workout' => $workout,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="workout_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Workout $workout): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workout->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workout);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workout_index');
    }
}
