-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 18 Wrz 2018, 07:38
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `events`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_eventCategory`
--

CREATE TABLE `events_eventCategory` (
  `id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events_eventCategory`
--

INSERT INTO `events_eventCategory` (`id`, `category`) VALUES
(6, 'demonstracja'),
(5, 'gra miejska'),
(90, 'inne'),
(1, 'koncert'),
(2, 'kultura'),
(7, 'motoryzacja'),
(3, 'sport dla amatorów'),
(4, 'sport profesjonalny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_events`
--

CREATE TABLE `events_events` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time(5) NOT NULL,
  `endDate` date NOT NULL,
  `endTime` time(5) NOT NULL,
  `picture` text COLLATE utf8_polish_ci NOT NULL,
  `www` text COLLATE utf8_polish_ci NOT NULL,
  `province` text COLLATE utf8_polish_ci NOT NULL,
  `city` text COLLATE utf8_polish_ci NOT NULL,
  `address` text COLLATE utf8_polish_ci NOT NULL,
  `createdBy` text COLLATE utf8_polish_ci NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events_events`
--

INSERT INTO `events_events` (`id`, `name`, `description`, `category`, `startDate`, `startTime`, `endDate`, `endTime`, `picture`, `www`, `province`, `city`, `address`, `createdBy`, `createdOn`) VALUES
(6, 'koncert Organek dla K-c', 'super koncert na urodziny Katowic, Organek i przyjaciele, obiecujemy megazabawę!!!!', 'koncert', '2018-09-22', '19:00:00.00000', '2018-09-22', '22:00:00.00000', 'https://zapodaj.net/images/0b3db8f517d1c.jpg', '', 'śląskie', 'Katowice', 'Katowice Miasto Ogrodów', 'milarka', '2018-09-05 00:00:00'),
(10, 'super koncert Katowice', 'super koncert na urodziny Katowic, Organek i przyjaciele', 'koncert', '2018-09-06', '15:30:00.00000', '2018-09-11', '21:00:00.00000', 'https://stressfree.pl/wp-content/uploads/2012/08/dzieci-zabawa.png', '', 'śląskie', 'Katowice', 'Katowice Miasto Ogrodów', 'milarka', '2018-09-06 00:00:00'),
(13, 'koncert ARS Cameralis', 'koncert muzyczny w sali kameralnej NOSPR, w wykonaniu zespołu Akademii Muzycznej w Katowicach', 'kultura', '2018-11-16', '18:15:00.00000', '2018-11-16', '20:20:00.00000', 'https://zapodaj.net/images/3e4badfe26b17.jpg', 'http://www.nospr.org.pl/pl/', 'śląskie', 'Katowice', 'NOSPR', 'milarka', '2018-09-06 16:49:39'),
(14, 'zlot samochodowy', 'Już za niedługo w Katowicach na ul.Mięsnej za mięsnym odbędzie się co 23-roczny zlot samochodów marki TATA. To bardzo ekskluzywne wydarzenie i mogą pozwolić sobie na nie tylko bogaci ludzie. Pewnie chcecie wiedzieć ile kosztuje bilet. Żeby wejść na ten zlot obsługa musi wam podarować aż 10 zł, i dużo ludzi odmawia bo nie mają sumienia żeby to zrobić, dlatego to zlot tylko dla twardzieli. Oczywiście wszyscy kochają TATE i znają wszystkie modele tej marki więc liczę na dużą liczbę uczestników. Sam Kim Shi Sho She Sha Shim Tata powiedział że na zlocie pokażą nowy model, i że będzie miał silnik V20 o pojemności 15 litrów czego chyba mogliśmy się spodziewać po poprzednich modelach. Inżynierowie TATY zdradzili, że pracują już nad V24 chociaż moim zdaniem ten silnik dawno powinien być wprowadzony do samochodów tej marki. No, trochę się rozpędziłem. Jak chcecie się dowiedzieć więcej to przyjdźcie na zlot lub wejdźcie na stronę www.samocodytatysanajlepszeidlategoprzyjdenazlot.pl. Ja już nie mogę się doczekać. ', 'motoryzacja', '2018-10-01', '10:00:00.00000', '2018-10-03', '23:59:00.00000', 'https://zapodaj.net/images/94c769b8d5428.jpg', '', 'śląskie', 'Katowice', 'ul. Mięsna 387x', 'VIPantonio', '2018-09-06 22:07:59'),
(15, 'zlot motocyklowy', 'Kręcimy bąki i wyprzedzamy inne motocykle', 'motoryzacja', '2018-12-12', '08:30:00.00000', '2018-12-13', '15:30:00.00000', 'https://zapodaj.net/images/a1df6075d049e.jpg', '', 'śląskie', 'Katowice', 'Dolina 3 Stawów', 'andy', '2018-09-06 22:12:55'),
(16, 'Układanie Origami', 'Układanie zwierząt z papieru za pomocą sztuki origami.', 'kultura', '2018-11-11', '11:30:00.00000', '2018-11-11', '13:30:00.00000', 'https://zapodaj.net/images/9a299e3246a49.jpg', '', 'śląskie', 'Bytom', 'ul.Katowicka 10', 'andy', '2018-09-06 22:14:57'),
(20, 'zlot samochodowy', 'Zapraszamy na zlot samochodów marki MAMA. Jest on o wiele bardziej prestiżowy od zlotu samochodów marki TATA przez co więcej osób przychodzi na to wydarzenie. Jest to tak świetne, że sam prezes już napisał na Twitterze: \"nie mam zamiaru przegapić jedynego ciekawego wydarzenia w tej dziurze\". Pan prezydent natychmiast sie zrehabilitował i zapowiedział, że Sfinansuje konkurs na samochód marki MAMA z silnikiem V40 z jego podpisem. A TATKI jeszcze V24 nie wymyślili XD. Za wstęp płacisz bo jest to zlot dla NORMALNYCH ludzi. Powstała grupa na Facebooku dla tych co kupili bilety, jest również na niej regulamin konkursu Andrzeja. W tym roku będzie także dodatkowa atrakcja. Pokażemy film pt.: \"dlaczego nasze auta są lepsze od samochodów marki TATA\". Będzie także możliwość zniszczenia tej kupy złomu. wystarczy poczekać na swoja kolej. Bilety kupisz na stronie a przy okazaniu potwierdzenia zakup naszego samochodu dostaniesz zniżkę 50% i większe szanse na wygraną w konkursie. Na dodatek nasz post na Facebooku polubiła sama królowa Elżbieta a jak to powiedział Einstein: \"lajki mówią same za siebie\". Zapraszamy gorąco. ', 'motoryzacja', '2018-09-30', '10:00:00.00000', '2018-10-03', '18:00:00.00000', 'https://zapodaj.net/images/a6f9b1a65540e.jpg', 'http://www.lepszeodtaty.pl/0,0.html', 'opolskie', 'Wódka', 'ul. unnamed road', 'maciekmaciek', '2018-09-10 14:30:13'),
(21, 'mecz GKS Katowice - Ruch Chorzów', 'Zapraszamy na Stadion Śląski na najważniejszy mecz sezonu. GKS Katowice kontra Ruch Chorzów. Kto okaże się silniejszy, kto przygarnie punkty? Przyjdź i poczuj emocje na własnej skórze! Każdy kibic mile widziany!!!!!', 'sport profesjonalny', '2018-09-23', '18:00:00.00000', '2018-09-23', '21:00:00.00000', 'https://zapodaj.net/images/5e43537bf5f6d.jpg', 'http://www.stadionslaski.mecz.pl/0,0.html', 'śląskie', 'Chorzów', 'Park Śląski, Stadion Śląski', 'milarka', '2018-09-11 16:51:29'),
(22, 'orientiring ', 'Chociaż nazwa to: ,, orientiring\" ( dałem taką nazwę tylko po to żeby mama w to weszła i zobaczyła co to jest chociaż i tak by weszła ale na wypadek to zrobiłem )  i kategoria wydarzenia to gra miejska, to tak naprawdę to wydarzenie polowanie, a właściwie łowy bo nie chcemy zabić tropionego gatunku gdyż jest dla nas niezwykle ważny. Teraz zgadujcie gatunek, którego będziemy szukać. Nic bardziej mylnego, to będą łowy na Make Pake! Gatunek ten występuje w kamienno-tropikalnych pustyniach leśnych, najczęściej Sosnowskich. Maka Paka jest piekielnie trudny do wytropienia, ponieważ świetnie kamufluje się w kamieniach, a szczególnie w wyczyszczonych przez samego Make Pake. A wierzcie mi na słowo że Maka Paka jest niepokonana w czyszczeniu kamieni, na dodatek na kamieniach nie ma śladów dlatego trudno będzie znaleźć trop. Żeby nie robić zbyt dużego hałasu na łowy pójdzie tylko 2 myśliwych, ale nie byle jakich, gdyż będą to dwaj najlepsi myśliwi na świecie. Pierwszy z nich to Mikulusurus Mikularus, ten grecki myśliwy\r\ndwukrotnie zdobył złoty medal na mistrzostwach świata w polowaniu na muszkę owocówkę, którą przy zdobyciu pierwszego złotego medalu zestrzelił ze swojego karabinu snajpersko-myśliwskiego z odległości 83749 kilometrów. Drugim myśliwym jest Sosnowiańczyk Janusz Cebulański, który w swoich myśliwskich sandałach może przejść bezszelestnie po suchych liściach nawet z naciskiem wagi Janusza. Skarpetki Janusza są zrobione ze specjalnego materiału przez co zwierzyna nie może wyczuć jego potu ze stóp. Sam Janusz choć jest bardzo dobrym myśliwym nie zdobył żadnego tytułu ale łowy odbędą się właśnie w sosnowieckich kamienno-tropikalnych pustyniach leśnych a Janusz zna te tereny jak własną kieszeń.\r\n No to właściwie tyle i w sumie nie musieliście tego czytać bo nie można w czasie łowów zbliżać się do sosnowieckich kamienno-tropikalnych pustyń leśnych na 500 kilometrów gdyż Maka Paka ma uszy z kamienia i usłyszy mrugnięcie oka z 200 kilometrów a wszyscy co żyją w tym okręgu będą zmuszeni do opuszczenia domów na czas łowów czyli około 2 lata. Powinienem to powiedzieć na początku ale łowy odbędą się dopiero w maju gdyż Maka Paka zapadając w sen zimowy zamienia się w kamień czyli właściwie to w zimę nie istnieje. Cześć, do następnego wydarzenia ;)', 'gra miejska', '2019-05-15', '09:00:00.00000', '2021-05-15', '19:00:00.00000', 'https://zapodaj.net/images/546f355775c92.jpg', '', 'śląskie', 'Sosnowiec', 'sosnowieckie kamienno-tropikalne pustynie leśne', 'VIPantonio', '2018-09-11 20:32:47'),
(24, 'Bieg na orientację', 'Zapraszamy wszystkich chętnych na bieg na orientację. Różne dystanse, mnóstwo ukrytych punktów od odhaczenia - nie wahaj się - zapisz się jeszcze dziś!!! Świetna zabawa gwarantowana. :-)', 'sport', '2018-09-22', '10:00:00.00000', '2018-09-22', '20:00:00.00000', 'https://zapodaj.net/images/2b27f5c360536.jpg', '', 'małopolskie', 'Kraków', 'Planty', 'milarka', '2018-09-13 10:49:48'),
(25, 'Taniec pod palmami', 'Zapraszamy wszystkich na ostatni w tym roku taniec pod palmami na rynku Katowic. Tym razem tańczymy salsę!', 'inne', '2018-09-15', '18:00:00.00000', '2018-09-15', '20:00:00.00000', 'https://zapodaj.net/images/3180de80994b5.jpg', '', 'śląskie', 'Katowice', 'Rynek', 'milarka', '2018-09-14 09:47:09'),
(26, 'Pokaz sztucznych ogni', 'zapraszamy na niezwykłe wydarzenie - wspaniały pokaz sztucznych ogni', 'inne', '2018-10-21', '21:00:00.00000', '2018-10-21', '23:59:00.00000', 'https://zapodaj.net/images/3180de80994b5.jpg', '', 'małopolskie', 'Kraków', 'Planty', 'milarka', '2018-09-14 09:51:07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_province`
--

CREATE TABLE `events_province` (
  `province` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events_province`
--

INSERT INTO `events_province` (`province`) VALUES
('dolnośląskie'),
('kujawsko-pomorskie'),
('lubelskie'),
('lubuskie'),
('łódzkie'),
('małopolskie'),
('mazowieckie'),
('opolskie'),
('podkarpackie'),
('podlaskie'),
('pomorskie'),
('śląskie'),
('świętokrzyskie'),
('warmińsko-mazurskie'),
('wielkopolskie'),
('zachodniopomorskie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_users`
--

CREATE TABLE `events_users` (
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events_users`
--

INSERT INTO `events_users` (`login`, `password`, `email`) VALUES
('adam', '$2y$10$f1i0LwMp3/JsqMUBmxVLEOZxzdAq/BWc5b/VAUU/3O0FWn0R1ACRy', 'adam@gmail.com'),
('adam1', '$2y$10$VTO0ZGXDozB837xhjKUnkes3sag1IPrdOZqU4nARvCExP9vcMwi.C', 'adam@gmail1.com'),
('adam123', '$2y$10$EjT6nbuYe32sykKW8oOgweG6Ur1OKBbF1sfBX4efro0sis/rBbUP6', 'nowakowski@gmail.com'),
('andy', '$2y$10$R0zFdfzOozWmS1dzhVor5u3jJlV2rksY6II.LQjdo.DicMNk54K0u', 'andy@onet.pl'),
('iksinski', '$2y$10$sNP1a72aSkcyoSlNqN8KW.e5Meck.AJqfx.t5QPoMqK/pFIOHdM6.', 'iksinski@gmail.com'),
('ilona', '$2y$10$3wMgPQP3LzVD6an3DT1WseUvGSQ0j8Xwytm/wkeZRm5XX.HXULfqq', 'ilona@gmail.com'),
('lrudzka', '$2y$10$pzmej1QFfmfB7sPmi3vP4uNZru9aJ9hO1/1vCVqCKT1ylKCBzjoCC', 'lrudzka@onet.eu1'),
('lucyna', '$2y$10$paxyvzw7vstwHUVpPDWcFu60GOqtZgt6IgQN3VhsHpYU643SE23Xa', 'lucyna@gmail.com'),
('lucyna1', '$2y$10$YytlOPkIVXeYejcIlRH0cuJnvHv8DrOWqAA7CFnJpx5oaC8SrSKRK', 'lucyna1@gmail.com'),
('maciekmaciek', '$2y$10$TphaOeqB0MEHgROwWhDYGu0zxUxK7bfAU7JmbFcewcNjQEuxeb71K', 'maciek@gmail.com'),
('milarka', '$2y$10$bZtwuk7eL89DRkCfxYN45unrAgfayi9ANfAKVXh7y1D1G3awditQ2', 'lrudzka@onet.eu'),
('piotr', '$2y$10$Ej71PiYeeTVQno5nwm2Kl.bf81A3ANXhrO3Uv1W8fvAWfI3icT2My', 'piotr@gmail.com'),
('VIPantonio', '$2y$10$EgkhjRao.hRMT8DZPLnwaeOQe3WjGQ39UfMJsnh17eCRbVZMoIFda', 'antek.rudzki@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events_eventCategory`
--
ALTER TABLE `events_eventCategory`
  ADD PRIMARY KEY (`category`(30));

--
-- Indeksy dla tabeli `events_events`
--
ALTER TABLE `events_events`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `events_province`
--
ALTER TABLE `events_province`
  ADD PRIMARY KEY (`province`(40));

--
-- Indeksy dla tabeli `events_users`
--
ALTER TABLE `events_users`
  ADD PRIMARY KEY (`login`(15)),
  ADD UNIQUE KEY `email` (`email`(100));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `events_events`
--
ALTER TABLE `events_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
