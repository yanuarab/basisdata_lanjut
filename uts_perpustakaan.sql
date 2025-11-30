--
-- PostgreSQL database dump
--

\restrict Cku8mdDnZX4zkXeYnrRbKjNaWjFPKgwN3SBHaDEjyvces2Xrwy9RQRt3lmhXOl5

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.6

-- Started on 2025-11-27 00:16:56

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 236 (class 1255 OID 16831)
-- Name: hitung_denda(date, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.hitung_denda(tgl_kembali date, tgl_pengembalian date) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
BEGIN
  RETURN GREATEST(0, EXTRACT(DAY FROM (tgl_pengembalian - tgl_kembali)) * 1000);
END;
$$;


ALTER FUNCTION public.hitung_denda(tgl_kembali date, tgl_pengembalian date) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 235 (class 1259 OID 16959)
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admins (
    admin_id integer NOT NULL,
    username character varying(50) NOT NULL,
    password_hash character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.admins OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 16958)
-- Name: admins_admin_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admins_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admins_admin_id_seq OWNER TO postgres;

--
-- TOC entry 5012 (class 0 OID 0)
-- Dependencies: 234
-- Name: admins_admin_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admins_admin_id_seq OWNED BY public.admins.admin_id;


--
-- TOC entry 217 (class 1259 OID 16832)
-- Name: seq_anggota; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_anggota
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seq_anggota OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16833)
-- Name: anggota; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.anggota (
    id_anggota integer DEFAULT nextval('public.seq_anggota'::regclass) NOT NULL,
    nama character varying(100) NOT NULL,
    alamat text,
    no_hp character varying(15),
    tanggal_gabung date DEFAULT CURRENT_DATE
);


ALTER TABLE public.anggota OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16840)
-- Name: seq_buku; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_buku
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seq_buku OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16841)
-- Name: buku; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.buku (
    id_buku integer DEFAULT nextval('public.seq_buku'::regclass) NOT NULL,
    judul character varying(100) NOT NULL,
    pengarang character varying(100),
    tahun_terbit integer,
    id_kategori integer,
    id_penerbit integer,
    stok integer DEFAULT 0,
    isbn character varying(20),
    CONSTRAINT buku_tahun_terbit_check CHECK ((tahun_terbit >= 1900))
);


ALTER TABLE public.buku OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16847)
-- Name: kategori_buku; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kategori_buku (
    id_kategori integer NOT NULL,
    nama_kategori character varying(50) NOT NULL,
    deskripsi text
);


ALTER TABLE public.kategori_buku OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16852)
-- Name: kategori_buku_id_kategori_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kategori_buku_id_kategori_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kategori_buku_id_kategori_seq OWNER TO postgres;

--
-- TOC entry 5013 (class 0 OID 0)
-- Dependencies: 222
-- Name: kategori_buku_id_kategori_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kategori_buku_id_kategori_seq OWNED BY public.kategori_buku.id_kategori;


--
-- TOC entry 223 (class 1259 OID 16853)
-- Name: penerbit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.penerbit (
    id_penerbit integer NOT NULL,
    nama_penerbit character varying(100) NOT NULL,
    kota character varying(50) DEFAULT 'Malang'::character varying
);


ALTER TABLE public.penerbit OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16857)
-- Name: mv_buku_deskripsi; Type: MATERIALIZED VIEW; Schema: public; Owner: postgres
--

CREATE MATERIALIZED VIEW public.mv_buku_deskripsi AS
 SELECT p.nama_penerbit,
    count(b.id_buku) AS jumlah_buku,
    k.nama_kategori
   FROM ((public.buku b
     JOIN public.penerbit p ON ((b.id_penerbit = p.id_penerbit)))
     JOIN public.kategori_buku k ON ((b.id_kategori = k.id_kategori)))
  GROUP BY p.nama_penerbit, k.nama_kategori
  WITH NO DATA;


ALTER MATERIALIZED VIEW public.mv_buku_deskripsi OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16862)
-- Name: seq_peminjaman; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_peminjaman
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seq_peminjaman OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16863)
-- Name: peminjaman; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman (
    id_peminjaman integer DEFAULT nextval('public.seq_peminjaman'::regclass) NOT NULL,
    id_anggota integer,
    id_buku integer,
    tanggal_pinjam date DEFAULT CURRENT_DATE,
    tanggal_kembali date,
    status character varying(20) DEFAULT 'Dipinjam'::character varying
);


ALTER TABLE public.peminjaman OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16869)
-- Name: mv_buku_populer; Type: MATERIALIZED VIEW; Schema: public; Owner: postgres
--

CREATE MATERIALIZED VIEW public.mv_buku_populer AS
 SELECT b.id_buku,
    b.judul,
    count(p.id_peminjaman) AS total_pinjam
   FROM (public.buku b
     JOIN public.peminjaman p ON ((b.id_buku = p.id_buku)))
  GROUP BY b.id_buku, b.judul
  WITH NO DATA;


ALTER MATERIALIZED VIEW public.mv_buku_populer OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16873)
-- Name: penerbit_id_penerbit_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.penerbit_id_penerbit_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.penerbit_id_penerbit_seq OWNER TO postgres;

--
-- TOC entry 5014 (class 0 OID 0)
-- Dependencies: 228
-- Name: penerbit_id_penerbit_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.penerbit_id_penerbit_seq OWNED BY public.penerbit.id_penerbit;


--
-- TOC entry 229 (class 1259 OID 16874)
-- Name: seq_pengembalian; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_pengembalian
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seq_pengembalian OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16875)
-- Name: pengembalian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pengembalian (
    id_pengembalian integer DEFAULT nextval('public.seq_pengembalian'::regclass) NOT NULL,
    id_peminjaman integer,
    tanggal_pengembalian date DEFAULT CURRENT_DATE,
    denda numeric(10,2) DEFAULT 0
);


ALTER TABLE public.pengembalian OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16881)
-- Name: view_buku_kategori; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_buku_kategori AS
 SELECT b.id_buku,
    b.judul,
    p.nama_penerbit
   FROM (public.buku b
     JOIN public.penerbit p ON ((b.id_penerbit = p.id_penerbit)));


ALTER VIEW public.view_buku_kategori OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16885)
-- Name: view_buku_lengkap; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_buku_lengkap AS
 SELECT b.judul,
    k.nama_kategori,
    p.nama_penerbit,
    b.stok
   FROM ((public.buku b
     JOIN public.kategori_buku k ON ((b.id_kategori = k.id_kategori)))
     JOIN public.penerbit p ON ((b.id_penerbit = p.id_penerbit)));


ALTER VIEW public.view_buku_lengkap OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 16889)
-- Name: view_peminjaman_detail; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_peminjaman_detail AS
 SELECT a.nama,
    b.judul,
    p.tanggal_pinjam,
    g.tanggal_pengembalian,
    g.denda
   FROM (((public.peminjaman p
     JOIN public.anggota a ON ((p.id_anggota = a.id_anggota)))
     JOIN public.buku b ON ((p.id_buku = b.id_buku)))
     LEFT JOIN public.pengembalian g ON ((p.id_peminjaman = g.id_peminjaman)));


ALTER VIEW public.view_peminjaman_detail OWNER TO postgres;

--
-- TOC entry 4806 (class 2604 OID 16962)
-- Name: admins admin_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins ALTER COLUMN admin_id SET DEFAULT nextval('public.admins_admin_id_seq'::regclass);


--
-- TOC entry 4797 (class 2604 OID 16950)
-- Name: kategori_buku id_kategori; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategori_buku ALTER COLUMN id_kategori SET DEFAULT nextval('public.kategori_buku_id_kategori_seq'::regclass);


--
-- TOC entry 4798 (class 2604 OID 16951)
-- Name: penerbit id_penerbit; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penerbit ALTER COLUMN id_penerbit SET DEFAULT nextval('public.penerbit_id_penerbit_seq'::regclass);


--
-- TOC entry 5006 (class 0 OID 16959)
-- Dependencies: 235
-- Data for Name: admins; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admins (admin_id, username, password_hash, created_at) FROM stdin;
1	admin	$2y$10$Dq3U3TrSqF0aOgOUyQoiAeHzKx36eUSQgzOZJpOrEhShPcH8OhBzi	2025-11-16 23:38:12.722876
\.


--
-- TOC entry 4992 (class 0 OID 16833)
-- Dependencies: 218
-- Data for Name: anggota; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.anggota (id_anggota, nama, alamat, no_hp, tanggal_gabung) FROM stdin;
1	Andi Wijaya	Jl. Merpati 1, Malang	081234567001	2023-01-10
2	Budi Santoso	Jl. Kembang 5, Malang	081234567002	2023-02-12
3	Citra Putri	Jl. Melati 3, Malang	081234567003	2023-03-15
4	Dedi Hartono	Jl. Anggrek 7, Malang	081234567004	2023-04-20
5	Eka Prasetya	Jl. Flamboyan 9, Malang	081234567005	2023-05-22
6	Fajar Hidayat	Jl. Cempaka 2, Malang	081234567006	2023-06-18
7	Gita Lestari	Jl. Bunga 11, Malang	081234567007	2023-07-09
8	Hendra Ramadhan	Jl. Mawar 8, Malang	081234567008	2023-08-01
9	Intan Putra	Jl. Sakura 4, Malang	081234567009	2023-09-14
10	Joko Kartika	Jl. Teratai 6, Malang	081234567010	2023-10-05
11	Karina Nugroho	Jl. Dahlia 10, Malang	081234567011	2024-01-12
12	Lukas Siregar	Jl. Kenanga 12, Malang	081234567012	2024-02-09
13	Maya Santika	Jl. Sawo 14, Malang	081234567013	2024-03-02
14	Nadia Wijaya	Jl. Kamboja 16, Malang	081234567014	2024-04-21
15	Oka Rahman	Jl. Cendana 18, Malang	081234567015	2024-05-06
16	Putri Dewi	Jl. Melur 20, Malang	081234567016	2024-06-11
17	Qori Anwar	Jl. Bakung 22, Malang	081234567017	2024-07-19
18	Ratna Kuncoro	Jl. Kantil 24, Malang	081234567018	2024-08-23
19	Satria Aditya	Jl. Cakra 26, Malang	081234567019	2024-09-30
\.


--
-- TOC entry 4994 (class 0 OID 16841)
-- Dependencies: 220
-- Data for Name: buku; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.buku (id_buku, judul, pengarang, tahun_terbit, id_kategori, id_penerbit, stok, isbn) FROM stdin;
1	Pengantar Pemrograman	A. Susanto	2018	1	1	5	978-1-11111-01-1
3	Novel Senja	C. Putri	2016	2	3	2	978-1-11111-03-5
4	Sejarah Indonesiaku	D. Hartono	2012	3	4	4	978-1-11111-04-2
6	Manajemen 101	F. Hidayat	2020	5	6	6	978-1-11111-06-6
7	Dongeng Anak Nusantara	G. Lestari	2017	6	15	8	978-1-11111-07-3
8	Sains untuk Semua	H. Ramadhan	2014	7	9	2	978-1-11111-08-0
9	Kalkulus Dasar	I. Putra	2013	8	12	3	978-1-11111-09-7
10	Panduan Hidup Sehat	J. Kartika	2021	10	5	7	978-1-11111-10-3
11	Hukum Pidana	K. Nugroho	2010	11	11	2	978-1-11111-11-0
12	Bahasa dan Budaya	L. Siregar	2018	12	13	5	978-1-11111-12-7
13	Praktik Teknik Mesin	M. Santika	2016	13	14	4	978-1-11111-13-4
14	Fotografi Digital	N. Wijaya	2019	14	7	6	978-1-11111-14-1
15	Resep Nusantara	O. Rahman	2015	15	16	9	978-1-11111-15-8
16	Pengantar Psikologi	P. Dewi	2022	16	3	10	978-1-11111-16-5
17	Backpacking Asia	Q. Anwar	2011	17	17	2	978-1-11111-17-2
18	Ensiklopedia Mini	R. Kuncoro	2008	18	18	1	978-1-11111-18-9
19	Desain Arsitektur Modern	S. Aditya	2020	19	14	3	978-1-11111-19-6
20	Hobi Berkebun Praktis	T. Rahmi	2017	20	16	7	978-1-11111-20-2
2	Belajar SQL Praktis	B. Santoso	2019	1	2	8	978-1-11111-02-8
5	Dasar Filsafat	E. Prasetyo	2015	4	5	-1	978-1-11111-05-9
\.


--
-- TOC entry 4995 (class 0 OID 16847)
-- Dependencies: 221
-- Data for Name: kategori_buku; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kategori_buku (id_kategori, nama_kategori, deskripsi) FROM stdin;
1	Teknologi	Buku tentang IT, pemrograman, dan teknologi
2	Sastra	Novel, puisi, dan karya sastra
3	Sejarah	Buku sejarah dunia dan nasional
4	Filsafat	Buku tentang pemikiran dan filsafat
5	Bisnis	Buku manajemen, pemasaran, kewirausahaan
6	Anak-anak	Cerita dan buku edukasi anak-anak
7	Ilmu Pengetahuan	Sains dasar dan terapan
8	Matematika	Buku matematika dan statistik
9	Agama	Buku keagamaan dan spiritualitas
10	Kesehatan	Kesehatan umum dan kedokteran dasar
11	Hukum	Buku hukum dan peraturan
12	Filologi	Kajian bahasa dan sastra klasik
13	Teknik	Teknik mesin, listrik, sipil, dsb.
14	Fotografi	Teknik dan teori fotografi
15	Kuliner	Buku resep dan teknik memasak
16	Psikologi	Buku perilaku dan psikologi
17	Perjalanan	Travel guide dan cerita perjalanan
18	Referensi	Kamus, ensiklopedia, manual
19	Arsitektur	Desain dan teori arsitektur
20	Hobby	Kerajinan, berkebun, DIY
\.


--
-- TOC entry 5000 (class 0 OID 16863)
-- Dependencies: 226
-- Data for Name: peminjaman; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman (id_peminjaman, id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) FROM stdin;
1	1	2	2024-10-01	2024-10-08	Kembali
2	2	3	2024-10-02	\N	Dipinjam
3	3	1	2024-09-25	2024-10-02	Kembali
4	4	5	2024-10-05	\N	Dipinjam
5	5	7	2024-09-20	2024-09-27	Kembali
6	6	6	2024-10-10	\N	Dipinjam
7	7	8	2024-08-15	2024-08-22	Kembali
8	8	10	2024-07-01	2024-07-10	Kembali
9	9	11	2024-09-01	\N	Dipinjam
10	10	4	2024-10-12	\N	Dipinjam
11	11	12	2024-06-05	2024-06-12	Kembali
12	12	13	2024-05-20	2024-05-27	Kembali
13	13	14	2024-10-14	\N	Dipinjam
14	14	15	2024-09-30	2024-10-07	Kembali
15	15	16	2024-10-08	\N	Dipinjam
16	16	17	2024-08-02	2024-08-09	Kembali
17	17	18	2024-07-15	2024-07-22	Kembali
18	18	19	2024-10-03	\N	Dipinjam
19	19	20	2024-10-11	\N	Dipinjam
20	\N	9	2024-09-05	2024-09-12	Kembali
21	3	5	2025-10-23	\N	Dipinjam
\.


--
-- TOC entry 4997 (class 0 OID 16853)
-- Dependencies: 223
-- Data for Name: penerbit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.penerbit (id_penerbit, nama_penerbit, kota) FROM stdin;
1	Gramedia	Jakarta
2	Erlangga	Surabaya
3	Mizan	Bandung
4	Bentang	Yogyakarta
5	Kompas	Jakarta
6	Prenada	Jakarta
7	Justin	KedungKandang
8	RIfat	Milan
9	Springer	Berlin
10	Cambridge Univ Press	Cambridge
11	Oxford Univ Press	Oxford
12	Yanuar	Pasuruan
13	Wiley	Hoboken
14	Routledge	London
15	Penerbit Anak	Malang
16	Agromedia	Bogor
17	PT Buku Kita	Semarang
18	NouraBooks	Jakarta
19	IndiBooks	Bali
20	Pelita	Medan
\.


--
-- TOC entry 5004 (class 0 OID 16875)
-- Dependencies: 230
-- Data for Name: pengembalian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pengembalian (id_pengembalian, id_peminjaman, tanggal_pengembalian, denda) FROM stdin;
1	1	2024-10-08	0.00
2	3	2024-10-02	0.00
3	5	2024-09-27	0.00
4	7	2024-08-22	0.00
5	8	2024-07-10	0.00
6	11	2024-06-12	0.00
7	12	2024-05-27	0.00
8	14	2024-10-07	0.00
9	16	2024-08-09	0.00
10	17	2024-07-22	0.00
11	20	2024-09-12	0.00
12	4	\N	0.00
13	2	\N	0.00
14	6	\N	0.00
15	9	\N	0.00
16	10	\N	0.00
17	13	\N	0.00
18	15	\N	0.00
19	18	\N	0.00
20	19	\N	0.00
\.


--
-- TOC entry 5015 (class 0 OID 0)
-- Dependencies: 234
-- Name: admins_admin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admins_admin_id_seq', 1, false);


--
-- TOC entry 5016 (class 0 OID 0)
-- Dependencies: 222
-- Name: kategori_buku_id_kategori_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kategori_buku_id_kategori_seq', 1, false);


--
-- TOC entry 5017 (class 0 OID 0)
-- Dependencies: 228
-- Name: penerbit_id_penerbit_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.penerbit_id_penerbit_seq', 1, false);


--
-- TOC entry 5018 (class 0 OID 0)
-- Dependencies: 217
-- Name: seq_anggota; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_anggota', 1, false);


--
-- TOC entry 5019 (class 0 OID 0)
-- Dependencies: 219
-- Name: seq_buku; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_buku', 1, false);


--
-- TOC entry 5020 (class 0 OID 0)
-- Dependencies: 225
-- Name: seq_peminjaman; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_peminjaman', 22, true);


--
-- TOC entry 5021 (class 0 OID 0)
-- Dependencies: 229
-- Name: seq_pengembalian; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seq_pengembalian', 1, false);


--
-- TOC entry 4833 (class 2606 OID 16965)
-- Name: admins admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (admin_id);


--
-- TOC entry 4835 (class 2606 OID 16967)
-- Name: admins admins_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_username_key UNIQUE (username);


--
-- TOC entry 4810 (class 2606 OID 16897)
-- Name: anggota anggota_no_hp_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anggota
    ADD CONSTRAINT anggota_no_hp_key UNIQUE (no_hp);


--
-- TOC entry 4812 (class 2606 OID 16899)
-- Name: anggota anggota_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.anggota
    ADD CONSTRAINT anggota_pkey PRIMARY KEY (id_anggota);


--
-- TOC entry 4814 (class 2606 OID 16901)
-- Name: buku buku_isbn_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buku
    ADD CONSTRAINT buku_isbn_key UNIQUE (isbn);


--
-- TOC entry 4816 (class 2606 OID 16903)
-- Name: buku buku_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buku
    ADD CONSTRAINT buku_pkey PRIMARY KEY (id_buku);


--
-- TOC entry 4820 (class 2606 OID 16905)
-- Name: kategori_buku kategori_buku_nama_kategori_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategori_buku
    ADD CONSTRAINT kategori_buku_nama_kategori_key UNIQUE (nama_kategori);


--
-- TOC entry 4822 (class 2606 OID 16907)
-- Name: kategori_buku kategori_buku_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategori_buku
    ADD CONSTRAINT kategori_buku_pkey PRIMARY KEY (id_kategori);


--
-- TOC entry 4829 (class 2606 OID 16909)
-- Name: peminjaman peminjaman_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman
    ADD CONSTRAINT peminjaman_pkey PRIMARY KEY (id_peminjaman);


--
-- TOC entry 4824 (class 2606 OID 16911)
-- Name: penerbit penerbit_nama_penerbit_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penerbit
    ADD CONSTRAINT penerbit_nama_penerbit_key UNIQUE (nama_penerbit);


--
-- TOC entry 4826 (class 2606 OID 16913)
-- Name: penerbit penerbit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penerbit
    ADD CONSTRAINT penerbit_pkey PRIMARY KEY (id_penerbit);


--
-- TOC entry 4831 (class 2606 OID 16915)
-- Name: pengembalian pengembalian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pengembalian
    ADD CONSTRAINT pengembalian_pkey PRIMARY KEY (id_pengembalian);


--
-- TOC entry 4817 (class 1259 OID 16916)
-- Name: idx_buku_judul; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_buku_judul ON public.buku USING btree (judul);


--
-- TOC entry 4818 (class 1259 OID 16917)
-- Name: idx_buku_stok_tersedia; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_buku_stok_tersedia ON public.buku USING btree (judul) WHERE (stok > 0);


--
-- TOC entry 4827 (class 1259 OID 16918)
-- Name: idx_peminjaman_dipinjam; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_peminjaman_dipinjam ON public.peminjaman USING btree (status) WHERE ((status)::text = 'Dipinjam'::text);


--
-- TOC entry 4836 (class 2606 OID 16919)
-- Name: buku buku_id_kategori_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buku
    ADD CONSTRAINT buku_id_kategori_fkey FOREIGN KEY (id_kategori) REFERENCES public.kategori_buku(id_kategori);


--
-- TOC entry 4837 (class 2606 OID 16924)
-- Name: buku buku_id_penerbit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buku
    ADD CONSTRAINT buku_id_penerbit_fkey FOREIGN KEY (id_penerbit) REFERENCES public.penerbit(id_penerbit);


--
-- TOC entry 4838 (class 2606 OID 16929)
-- Name: peminjaman peminjaman_id_anggota_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman
    ADD CONSTRAINT peminjaman_id_anggota_fkey FOREIGN KEY (id_anggota) REFERENCES public.anggota(id_anggota);


--
-- TOC entry 4839 (class 2606 OID 16934)
-- Name: peminjaman peminjaman_id_buku_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman
    ADD CONSTRAINT peminjaman_id_buku_fkey FOREIGN KEY (id_buku) REFERENCES public.buku(id_buku);


--
-- TOC entry 4840 (class 2606 OID 16939)
-- Name: pengembalian pengembalian_id_peminjaman_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pengembalian
    ADD CONSTRAINT pengembalian_id_peminjaman_fkey FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman);


--
-- TOC entry 4998 (class 0 OID 16857)
-- Dependencies: 224 5008
-- Name: mv_buku_deskripsi; Type: MATERIALIZED VIEW DATA; Schema: public; Owner: postgres
--

REFRESH MATERIALIZED VIEW public.mv_buku_deskripsi;


--
-- TOC entry 5001 (class 0 OID 16869)
-- Dependencies: 227 5008
-- Name: mv_buku_populer; Type: MATERIALIZED VIEW DATA; Schema: public; Owner: postgres
--

REFRESH MATERIALIZED VIEW public.mv_buku_populer;


-- Completed on 2025-11-27 00:16:57

--
-- PostgreSQL database dump complete
--

\unrestrict Cku8mdDnZX4zkXeYnrRbKjNaWjFPKgwN3SBHaDEjyvces2Xrwy9RQRt3lmhXOl5

