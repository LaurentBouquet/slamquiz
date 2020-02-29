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
     * @Route("/{id}", name="workout_new", methods={"GET"})
     */
    public function new(Request $request, int $id, EntityManagerInterface $em): Response
    {
        $quizRepository = $em->getRepository(Quiz::class);
        $quiz = $quizRepository->findOneBy([
            'id' => $id
        ]);
        dump($quiz);
        
        $workout = new Workout();
        $workout->setStartedAt(new \DateTime());
        //$workout->setEndedAt(new \DateTime());
        $workout->setQuiz($quiz);
        $workout->setNumberOfQuestions(1);
        $workout->setCompleted(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($workout);
        $entityManager->flush();

        $questionRepository = $em->getRepository(Question::class);
        $nextQuestion = $questionRepository->findOneRandomByCategories($quiz->getCategories());
        $form = $this->createForm(QuestionType::class, $nextQuestion, array('form_type'=>'student_questioning'));
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            // return $this->redirectToRoute('workout_next');
        }

        return $this->render('workout/new.html.twig', [
            'workout' => $workout,
            'quiz' => $quiz,
            'progress' => ($workout->getNumberOfQuestions()/$quiz->getNumberOfQuestions())*100,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="workout_next", methods={"GET"})
     */
    public function next(Workout $workout): Response
    {
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
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
