--
-- PostgreSQL database dump
--

-- Dumped from database version 12.0
-- Dumped by pg_dump version 12.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: tbl_category; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.tbl_category (id, shortname, longname) FROM stdin;
4	POO	Programmation Orientée Objet
5	PHP	Langage PHP
6	Symf4	Symfony version 4
\.


--
-- Data for Name: tbl_user; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.tbl_user (id, email, roles, password) FROM stdin;
2	l.bouquet@ndlaprovidence.org	["ROLE_SUPER_ADMIN"]	$argon2i$v=19$m=65536,t=4,p=1$R3BMSFhRWlR2M2ttUWlmQw$E0kiymGEVsVQH4B4zV32l+K7BmhpiQAY9bx+CQq0cMY
4	test@test.fr	[]	$argon2i$v=19$m=65536,t=4,p=1$WTVmQlZ3U1EyQS5yREREUw$DuzszN2OhyLXCGLJ6auf7z2YJIOirmTQIiCNXyWVLVk
\.


--
-- Name: tbl_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.tbl_category_id_seq', 6, true);


--
-- Name: tbl_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.tbl_user_id_seq', 4, true);


--
-- PostgreSQL database dump complete
--

