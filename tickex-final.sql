-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Maj 2023, 14:57
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `tickex`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `EventName` tinytext NOT NULL,
  `DateOfEvent` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `EventCity` text NOT NULL,
  `EventPlace` mediumtext NOT NULL,
  `AvailabeSpots` int(11) NOT NULL,
  `TicketPrice` text NOT NULL,
  `Category` tinytext NOT NULL,
  `Description` text NOT NULL,
  `OrganiserContactEmail` text NOT NULL,
  `OrganiserContactPhone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `events`
--

INSERT INTO `events` (`EventID`, `EventName`, `DateOfEvent`, `EventCity`, `EventPlace`, `AvailabeSpots`, `TicketPrice`, `Category`, `Description`, `OrganiserContactEmail`, `OrganiserContactPhone`) VALUES
(1, 'SBM FFestival 2023', '2023-08-23 14:00:00', 'Warszawa', 'Lotnisko Bemowo', 300, '200', 'RAP', 'Ponownie zabierzemy Was na Lotnisko Bemowo w Warszawie i tym razem festiwal odbędzie się 23 sierpnia 2023.Przedsprzedaż biletów w aplikacji tickEX i wszystkich stacjonarnych salonach Empik w Polsce wystartuje w czwartek o godzinie 18:00. Stay tuned!', 'maneesh@icloud.com', '765482572'),
(2, 'BiG Festivalowski', '2023-08-18 12:00:00', 'Plock', 'Stary Rynek w Plocku', 150, '100', 'STAND-UP', 'Rusza sprzedaż biletów na drugą edycję jedynego w Europie Festiwalu Sztuki Pozytywnej i Miękkich Treści!!\r\nZanurz się w leniwej atmosferze Płocka i śmiej z nami na przedlądzie filmowym najlepszych światowych komedii czy gali stand-upu!', 'jnolan@mac.com', '689256935'),
(3, 'Margaret MTV Unplugged', '2023-10-13 16:00:00', 'Wroclaw', 'Zaklete Rewiry', 600, '50', 'POP', 'Margaret świętuje dekadę obecności na scenie! Z tej okazji artystka nie tylko wydała album w kultowej formule MTV UNPLUGGED, ale przygotowała również trasę koncertową, promującą ten gruntownie odświeżony repertuar. Począwszy od 13. października 2023 największe hity artystki wybrzmią z nową energią w akustycznej, kubańskiej odsłonie i w towarzystwie 14-osobowego zespołu znakomitych instrumentalistów.', 'formis@live.com', '857284529'),
(4, 'Juwenalia SGH 2023', '2023-05-27 08:00:00', 'Warszawa', 'Szkola Glowna Handlowa', 800, '120', 'RAP', 'Już 27 maja w Ogrodach Rektorskich Szkoły Głównej Handlowej w Warszawie odbędzie się najgłośniejsze wydarzenie tego roku! Majowy wieczór w gronie znajomych, świetna atmosfera, znakomita muzyka… \r\nNa naszych 2 scenach zagra dla Was aż 8 wspaniałych, polskich artystów, a dodatkowo czekać na Was będzie strefa gastronomiczna, ogródek piwny oraz atrakcje i konkursy przygotowane przez partnerów wydarzenia! ', 'roesch@live.com', '123098456'),
(5, 'Asster – Mowa Węży', '2023-05-20 15:00:00', 'Warszawa', 'Proxima', 900, '250', 'RAP', 'Asster to pochodzący z Łodzi, młody reprezentant polskiej sceny rapowej. Z łatwością odnajduje się w nowoczesnych brzmieniach, ukazując przy tym niezwykle bogaty warsztat. Od dzieciństwa zajmował się muzyką, rozwijając swoje umiejętności wokalne na zajęciach śpiewu w domu kultury. Czysty głos, osadzony w średnich rejestrach pozwala mu doskonale lawirować na granicy rapowo-trapowych brzmień, w różnych gatunkach i stylistykach.', 'bigmauler@me.com', '234987564'),
(6, 'Benny The Butcher', '2023-05-23 10:00:00', 'Warszawa', 'Progresja', 50, '150', 'RAP', 'Amerykański raper Benny the Butcher po raz pierwszy w Polsce! Artysta wystąpi na jedynym koncercie w naszym kraju już 23 maja w warszawskim klubie Progresja.', 'jsmith@comcast.net', '067295672'),
(7, 'Ephemera 2023', '2023-06-15 14:00:00', 'Warszawa', 'Krolikalnia', 600, '200', 'POP', 'Minęły już trzy lata, odkąd tworzona przez zespół Unsoundu Ephemera przyszła na świat. W 2023 roku ten multidyscyplinarny festiwal ponownie pojawi się Warszawie, łącząc ze sobą różne środowiska: stołeczne organizacje, kuratorki i kuratorów, artystki i artystów z całego świata oraz publiczność. Inspirowana słowiańskimi obrzędami związanymi z letnim przesileniem, Ephemera pełna będzie światła, tańca, muzyki, sztuki, wspólnotowych doświadczeń i jedzenia.', 'jmcnamara@live.com', '294649293'),
(8, 'Rockowa Noc', '2023-08-25 17:00:00', 'Rzeszow', 'Miasteczko Akademickie Politechniki Rzeszowskiej', 30, '60', 'ROCK', 'ROCKOWA NOC to festiwal o MOCNYCH KORZENIACH – w 2023 roku będzie świętował swoje 18-ste urodziny i zdecydowanie będzie to NAJGŁOŚNIEJSZA IMPREZA W MIEŚCIE, do tego NAJWIĘKSZA 18-tka W POLSCE!\r\nDaj się porwać w wir imprezy i poczuj na własnej skórze kawał historii polskiego rocka! ROCKOWA NOC 2023 to dwa dni dobrej zabawy 25 i 26 sierpnia na terenie festiwalowym w samymsercu Rzeszowa – na Miasteczku Akademickim Politechniki Rzeszowskiej.', 'vganesh@att.net', '589392147'),
(9, 'Kazimiernikejszyn 2023', '2023-07-12 11:00:00', 'Kazimierz Dolny', 'Miasto Kazimierz Dolny', 1000, '150', 'STAND-UP', 'Kultowy Festiwal pierwszy raz w Going.! Jubileuszowa X edycja muzycznej celebracji bezpinkowości, bliskości i jasnej strony mocy zmiksowanej z dzikością zabawy po świt i magią Kazimierza Dolnego.\r\nKoncerty, autorskie przygody, spotkania i jedyny taki czas od chillu po szaleństwo.\r\nNo i publiczność jakiej nie znajdziecie nigdzie indziej.', 'shrapnull@msn.com', '578932943'),
(10, 'We Three', '2023-10-13 13:00:00', 'Warszawa', 'Praga Centrum', 850, '100', 'POP', 'We Three to zespół, który swoją popularność zyskał dzięki America’s Got Talent, w którym doszli do półfinału. Wykorzystali program jak trampolinę do sukcesu. Od tego czasu wydali trzy albumy studyjne i zyskali reputację zespołu, który porusza trudne tematy, związane ze zdrowiem psychicznym.', 'dawnsong@comcast.net', '942853954'),
(11, 'Speed Games x Driftingowe Mistrzostwa Polski', '2023-06-29 08:00:00', 'Warszawa', 'Tor Slomczyn k. Warszawy', 400, '200', 'WYSCIGI', 'Speed Games x Driftingowe Mistrzostwa Polski Najbardziej spektakularny Festiwal Motoryzacyjny w Polsce!\r\nJuż w maju przeżyj najlepszą motoryzacyjną przygodę roku - Speed Games łączy siły z Driftingowymi Mistrzostwami Polski! Nie przegap okazji, by zobaczyć, jak najlepsi kierowcy i gwiazdy przekraczają swoje granice na torze!', 'makarow@icloud.com', '562748284'),
(12, 'BASS ASTRAL | Impreza Taneczna', '2023-05-13 10:00:00', 'Szczecin', 'Kosmos', 850, '30', 'DYSKOTEKA', 'Bass Astral zaprasza na koncert w ramach trasy ‘Impreza Taneczna’, która jest preludium do jego nowego wydawnictwa ‘Muzyka Taneczna‘. Wystąpi w Klubie Kosmos w Szczecinie w sobotę, 13 maja, o godzinie 20:00. Podczas koncertu usłyszysz piosenki z debiutanckiego ‘Techno do miłości\', autorskie remixy znanych utworów, kompozycje z repertuaru Bass Astral x Igo i nowej nadchodzącej płyty. Wszystko to połączone w ekscytującą muzyczną podróż według najwyższych standardów sztuki dj-skiej.', 'mickywise@me.com', '673927572'),
(13, 'Wisłoujście 2023', '2023-08-18 12:00:00', 'Gdansk', 'Twierdza Wisloujscie', 50, '100', 'POP', 'Organizator: Wisłoujście Festival Sp. z o.o\r\nmore info: www.wisloujscie.com', 'gabbyunpleasant@optonline.net', '175932954'),
(14, 'TRŁ TRÓJMIASTO', '2023-05-13 07:00:00', 'Gdansk', 'AmberExpo', 900, '300', 'TARGI', 'Targi Rzeczy Ładnych to największe i najbardziej prestiżowe targi współczesnego polskiego designu i plakatu. Od 10 lat przyciągają tłumy w największych polskich miastach. A już w maju wielki debiut - TRŁ odbędą się po raz pierwszy w Trójmieście! Do gdańskiego AMBEREXPO na dwa dni przyjedzie ponad 200 najciekawszych marek i twórców mebli, ceramiki, czy ilustracji. Zapowiada się największe święto nowego wzornictwa i artykułów do wnętrz na północy Polski!', 'trustingmikey@mac.com', '938246291'),
(15, 'Hot Since 82', '2023-10-14 19:00:00', 'Warszawa', 'Praga Centrum', 2000, '10', 'DJ', 'Topowa postać elektronicznej sceny ostatnich kilku lat. Daley Padley rozpoczął swoją przygodę z DJ-ingiem już jako nastolatek, kiedy grywał kilkunastogodzinne sety podczas niedzielnych wydarzeń w jednym z klubów w rodzinnym mieście. Jako producent zadebiutował jednak znacznie później, bo dopiero w 2012 roku – wtedy ukazała się jego premierowa EP-ka „Forty Shorty” nakładem Get Physical. Potem były wydawnictwa m.in. w Noir Music czy Ultra Records, a w 2014 Daley postanowił otworzyć własną wytwórnię, Knee Deep, która dziś jest znana fanom w wielu krajach. Jego największe hity to „Veins”, „Like You” czy „Buggin’“.', 'spurtbad@msn.com', '405832692'),
(16, 'Voxnox: Alignment, Lucinee, Sept', '2023-05-12 19:00:00', 'Warszawa', 'Praga Centrum', 50, '150', 'TECHNO', 'VoxNox to kolektyw skupiający artystów, których cechuje alternatywne podejście do muzyki elektronicznej oraz chęć dążenia do wolności ekspresji w każdym wydaniu z jednoczesnym naciskiem na bezwzględny szacunek oraz tolerancję.', 'prepareunnatural@msn.com', '046284633'),
(17, 'Disney Księżniczki', '2023-05-14 10:00:00', 'Katowice', 'Spodek', 2500, '100', 'KONCERT', 'Najsłynniejsze piosenki Księżniczek Disneya zabrzmią na żywo.\r\nRusza seria koncertów w największych miastach w Polsce.\r\nHistorie Księżniczek i Królowych Disneya oczarowują i inspirują kolejne pokolenia. Uczą nas dostrzegać ukryte głęboko dobro, z odwagą odkrywać nowe światy i przekonują, że mamy tę moc. Nieodłączną częścią tych opowieści są wielkie, muzyczne przeboje.', 'contentdiarmi@gmail.com', '758920588'),
(18, 'Pentatonix', '2023-05-15 16:00:00', 'Warszawa', 'COS Torwar', 750, '250', 'KONCERT', 'O Pentatonix możemy bez wątpienia powiedzieć, że jest to najsłynniejszy zespół acapella na świecie. Bardzo słusznie został owiany legendarną sławą i co więcej zmuszony poniekąd do przeniesienia ponownego swojej światowej trasy. Ostatecznie koncert odbędzie się 15 maja 2023 roku na hali Torwar.', 'Audreycalm@yahoo.ca', '547294625'),
(19, 'Elderbrook', '2023-05-18 11:00:00', 'Poznan', 'Tama', 700, '100', 'ROCK', 'Elderbrook zagra 18.05.2023 w Poznaniu!\r\nNazwać Alexandra Kotza artystą elektronicznym to zdecydowanie za mało. To określenie nie wyjaśnia, że jest on jednocześnie wokalistą, pisarzem tekstów, producentem i multiinstrumentalistą. Choć faktycznie Elderbrook jest kojarzony najbardziej ze światem elektroniki, jego wpływy i inspiracje sięgają klasycznych gatunków, takich jak rock, country, soul czy rock – w końcu jego podstawowe wykształcenie muzyczne to gra na pianinie i gitarze.', 'Jamiecourageous@comcast.net', '946572846'),
(20, 'Paulina Przybysz \"Wracając\"', '2023-05-13 08:00:00', 'Katowice', 'Krolestwo', 50, '300', 'POP', 'Piosenki o równowadze, o oswajaniu smutku i cienia, o tęsknocie za naturą, o końcu świata, burdelu w polityce. O wewnętrznych cichych rewolucjach, subtelnościach w relacjach i z pewnością o miłości. Tego możemy spodziewać się po nadchodzącej trasie \"Wracając\".\r\n\r\nOdsłona koncertowa Pauliny Przybysz to nadal wiernie wybrzmiewające hip hop i soul. Tym razem jednak, Paulina wpuszcza do swojego świata elementy klasycznych popowych ballad, tanecznych momentów, głębokiego basu czy trapowej narracji rytmicznej. \"Wracając\" zobowiązuje! Poza nowymi piosenkami, usłyszycie powroty bardzo nieoczywiste - ale jakie, to do samego końca pozostanie tajemnicą.', 'vastCody@yahoo.co.in', '129573829'),
(21, 'Amber Run', '2023-05-23 17:00:00', 'Warszawa', 'Praga Centrum', 500, '100', 'ROCK', 'Organizator: Follow The Step\r\n\r\nRegulamin: www.followthestep.com/regulamin', 'punkis@att.net', '123478054'),
(22, 'Boris', '2023-05-31 15:00:00', 'Warszawa', 'Proxima', 800, '150', 'ROCK', 'Legendarna grupa Boris świętuje 30-lecie swojej działalności jako jednego z najcięższych i najbardziej innowacyjnych składów na scenie eksperymentalnej za sprawą wydanego w zeszłym roku albumu “Heavy Rocks”. Z tej okazji trio wyruszy w swoją kolejną trasę, na której znalazły się 2 polskie przystanki - warszawska Proxima oraz krakowski Kwadrat. W ramach supportu wystąpi japoński zespół Asunojokei.', 'balchen@gmail.com', '765267064'),
(23, 'Tess Parks', '2023-05-24 08:00:00', 'Warszawa', 'BARdzo bardzo', 100, '50', 'KONCERT', 'Tess zadebiutowała w 2013 roku albumem “Blood Hot”, który ukazał się pod egidą 359 Music. Jej kompozycje, w których niski głos łączy się z melodyjnymi, lo-fiowymi dźwiękami, idealnie pasowały do wytwórni prowadzonej przez Alana McGee, a sam krążek znalazł uznanie odbiorców na całym świecie.', 'jshearer@hotmail.com', '846728492'),
(24, 'Tempers', '2023-05-22 17:55:25', 'Warszawa', 'Klub Hydrozagadka', 200, '80', 'TECHNO', 'Nowojorski duet Tempers na dwóch koncertach w Polsce! Mroczne synthy, nastrojowe gitary i posępne wokale wybrzmią 24 maja w poznańskim Klubie Pod Minogą oraz dzień później w warszawskiej Hydrozagadce!\r\n', 'manuals@msn.com', '784928392'),
(25, 'Fun Lovin\' Criminals', '2023-07-19 16:00:00', 'Warszawa', 'Letnia Scena Progresji', 300, '300', 'ROCK', 'Fun Lovin\' Criminals to szalona i zaraźliwa mieszanka filmowego hip-hopu, rock\'n\'rolla, blues-jazzu oraz latynoskiego soulu! Zespół pojawił się na nowojorskiej scenie muzycznej w 1996 roku wraz z wydaniem pokrytego wielokrotną platyną, debiutanckiego albumu „Come Find Yourself”, który ukazał się w barwach legendarnej wytwórni EMI Records. Ich debiutancki singiel „Scooby Snacks”, wykorzystujący sample z klasycznych filmów Tarantino, takich jak Wściekłe psy i Pulp Fiction, spędził aż 17 tygodni na liście Billboard, szybko osiągając status złotej płyty w USA.', 'madler@yahoo.com', '765839201'),
(26, 'T-Fest', '2023-05-31 15:00:00', 'Warszawa', 'Klub Stodoła', 900, '500', 'RAP', 'T-Fest - popularny artysta hip-hopowy pochodzący z Chernivtsi. Ambasador ukraińskiej wytwórni muzycznej dla młodzieży, Lemniskata. Od początku swojej kariery nagrał i wydał sześć albumów studyjnych oraz dziesiątki głośnych hitów, które brzmią na całym świecie. 27 maja na scenie klubu Stodola w Warszawie artysta zaprezentuje swoje nowe show, w którym usłyszysz swoje ulubione piosenki w świeżym brzmieniu.', 'thrymm@hotmail.com', '098275843'),
(27, 'Collage', '2023-05-17 08:00:00', 'Warszawa', 'Progresja', 150, '200', 'ROCK', 'Ponad ćwierć wieku od wydania ostatniej płyty, warszawski Collage powraca z długo oczekiwanym nowym albumem, zatytułowanym „Over and Out”. Album miał swoją premierę na początku grudnia 2022 roku, ale historia tej płyty sięga roku 2013, gdy po wieloletniej przerwie w działalności, muzycy najbardziej znanego składu Collage, postanowili powrócić. Już przed powrotem na scenę rozeszły się drogi muzyków Collage i wokalisty Roberta Amiriana, którego zastąpił Karol Wróblewski, a następnie znany z zespołu Quidam, Bartek Kossowicz. Z kolei w 2015 roku decyzję o rozstaniu podjął jeden z założycieli grupy, Mirek Gil. Jego miejsce zajął Michał Kirmuć. Od tego momentu rozpoczął się nowy rozdział w historii Collage, którego efektem jest album „Over and Out”.', 'treit@icloud.com', '789120394'),
(28, 'JPEGMAFIA', '2023-06-01 18:00:00', 'Warszawa', 'Progresja', 1000, '250', 'RAP', 'Organizatorem wydarzenia jest Live Nation Sp. z o.o.', 'clkao@gmail.com', '982638920'),
(29, 'KIWI | Koncert Premierowy', '2023-05-25 15:00:00', 'Warszawa', 'Klub Hydrozagadka', 600, '40', 'POP', 'Pod pseudonimem KIWI kryje się Wiktoria Nazarian – krakowska wokalistka, kompozytorka i autorka tekstów. Mówi, że najpiękniejsze rzeczy powstają, kiedy zamknie się sam na sam z Abletonem. Uwielbia połączenie delikatnego wokalu z elektronicznym brzmieniem. Tworzy piosenki, które łapią za serce i hipnotyzują słuchacza. Swoją solową karierę rozpoczęła od akcji FONOBO Pitcher, w ramach której wydała swój debiutancki singiel. Kontynuując współpracę z FONOBO Label wypuściła EPkę \"Nocą\". Jej wrażliwość oraz świeże podejście do muzyki zostały docenione przez słuchaczy oraz Spotify. KIWI była jedną z twarzy pierwszej lokalnej odsłony projektu RADAR, którego celem jest wspieranie młodych artystów z Polski. Jej debiutancki album zatytułowany “Pętla\" ukazał się 28 stycznia 2022 r. i zebrał wyłącznie pozytywne recenzje. Przy okazji premiery płyty, artystka zagrała trasę koncertową w największych polskich miastach, którą wyprzedała w zaledwie kilka dni! Z premierowym materiałem wystąpiła również na scenach polskich festiwali - FEST Festival, OFF Camera, Great September. Jesienią wyruszyła w kolejną trasę koncertową i wypuściła wyjątkową live sesję, w ramach której zaprezentowała swoje najpopularniejsze numery w zupełnie nowej odsłonie. Już niebawem ukaże się jej kolejna EPka “PARANOJE”, którą promuje energetyczny singiel “Kruszysz” oraz mocny numer “Paranoje”.  ', 'reeds@live.com', '873029482'),
(30, 'Onoe Caponoe', '2023-05-27 16:00:00', 'Warszawa', 'Klub Hydrozagadka', 900, '120', 'RAP', 'Onoe Caponoe już na przełomie maja i czerwca wystąpi w Warszawie oraz Poznaniu, gdzie zaprezentuje materiał z wydanego w styczniu albumu “Concrete Fantasia”\r\n\r\nNadający z nieznanej części Londynu Onoe jest wyróżniającą się osobowością na tle morza klonów. Artysta wyrabia sobie pozycję w galaktyce pełnej hałasów, które wszystkie, niestety, brzmią tak samo. Poprzez mozolną i drobiazgową pracę na przestrzeni lat Caponoe doskonalił swoją wizję, co zaprowadziło go do krain, o których inni raperzy mogliby tylko pomarzyć. Zaczynając od projektowania okładek swoich albumów, przez przygotowywanie swoich wystaw, produkowanie beatów, na reżyserowaniu własnych klipów kończąc, Onoe jawi się jako niezwykle kreatywna dusza, której pomysłowość wyróżnia ją spośród reszty. W styczniu raper wydał swój piąty w dorobku album, “Concrete Fantasia”, na którym wśród gości znaleźli się m.in. Zdechły Osa, Lil B czy Sofie Royer.  ', 'gboss@comcast.net', '192839492'),
(31, 'Space Motion', '2023-06-01 14:00:00', 'Warszawa', 'Praga Centrum', 100, '100', 'TECHNO', 'Organizator: Follow The Step\r\nRegulamin: www.followthestep.com/regulamin', 'seebs@aol.com', '420394269'),
(32, 'MY 3', '2023-05-26 18:08:05', 'Warszawa', 'Hulakula Rozrywkowe Centrum Miasta', 900, '200', 'POP', 'MY3! WYSTĄPIĄ 4 CZERWCA W HULAKULA\r\n\r\nZ okazji Dnia Dziecka serdecznie zapraszamy na koncert nowego składu uwielbianego przez dzieci i młodzież zespołu MY3! Nowy skład MY3 tworzą Sandi, Amelia i Ola. Dziewczyny są już doskonale znane widzom telewizyjnym. Były one uczestniczkami show TVP2 - The Voice Kids MY3 to popularny wśród młodzieży skład prezentujący muzykę dla dzieci i młodzieży oraz prowadzący kanał na Youtube rozwijający różne pasje i zainteresowania.', 'fairbank@att.net', '192859302'),
(33, 'Vitalic live', '2023-06-06 18:00:00', 'Warszawa', 'Praga Centrum', 600, '400', 'TECHNO', 'Vitalic to francuski producent, multiinstrumentalista i live-performer, którego fanom tanecznej elektroniki nie trzeba przedstawiać.\r\n\r\nOd ponad 20 lat nieprzerwanie tworzy i występuje, ciągle zaskakując i dostarczając publiczności wielu niezapomnianych wrażeń. Tym razem Vitalic wraca do nas ze swoim najnowszym materiałem \"DISSIDÆNCE\". Musicie usłyszeć to na żywo!', 'dbrobins@outlook.com', '582930428'),
(34, 'GoGo Penguin', '2023-05-24 17:00:00', 'Warszawa', 'Progresja', 150, '250', 'KONCERT', 'Brytyjskie trio GoGo Penguin powraca z nowym, porywającym albumem “Everything Is Going to Be OK”, którego premiera planowana jest na kwiecień nakładem Sony Music XXIM! Z tej okazji nieco ponad rok po swoim ostatnich koncercie zespół powróci do Polski i wystąpi w warszawskiej Progresji.', 'philb@att.net', '102946283'),
(35, '2 Nights with the FIRE! ORCHESTRA', '2023-06-14 18:00:00', 'Warszawa', 'Pardon To tu', 450, '100', 'ROCK', 'Nie opadł jeszcze kurz po lutowych koncertach z zespołem \"The End\", a mamy już teraz olbrzymią przyjemność zaprosić na kolejne dwa bardzo wyjątkowe koncerty z saksofonistą Matsem Gustafssonem na czele: Napawa nas dumą, że pod koniec maja 2023 r. będziemy gościć u nas na pierwszych klubowych, pierwszych w Warszawie i jedynych koncertach w Polsce wyjątkowy 17-osobowy zespół który słynie z wybuchowej mieszanki współczesnej awangardy, kosmicznego free jazzu czy progresywnego rocka. Drodzy goście, bardzo serdecznie zapraszamy na dwa wieczory z legendarną FIRE! Orchestra!', 'jonadab@aol.com', '930492938'),
(36, 'Young Power House / Targi Książki Empiku | Empik x BeYA', '2023-05-28 19:00:00', 'Warszawa', 'Samo Centrum Wszechświata', 700, '50', 'TARGI', 'Katarzyna Barlińska, Natalia Fromuth, Monika Rutka, Marta Łabęcka, Monika Marszałek – to właśnie ich powieści zajmują najwyższe miejsca na listach bestsellerów i to właśnie do nich ustawiają się największe kolejki podczas wydarzeń literackich. Spotkaj ukochane autorki książek młodzieżowych w zupełnie innej od tradycyjnego spotkania autorskiego czy sesji autografów formule.\r\n\r\nW ramach wydarzenia Young Power House autorki opanują specjalnie na tę okazję zaaranżowaną przestrzeń kamienicy w centrum Warszawy. Każda z nich będzie miała tam kawałek swojego świata oddającego wyjątkowość i charakter jej twórczości. Uczestnicy w towarzystwie przewodników będą w niewielkich grupach przemieszczać się po kamienicy odwiedzając po kolei każdą z autorek i mając szasnę spędzić z nią chwilę, zadać nurtujące pytanie, zdobyć autograf czy zrobić sobie wspólne zdjęcie.', 'osaru@verizon.net', '682039489'),
(37, 'Festiwal Gier i Popkultury Pixel Heaven 2023 / Pixel Heaven Games & Pop Culture Festival 2023', '2023-06-07 11:00:00', 'Warszawa', 'Mińska 65', 200, '100', 'FESTIWAL', 'Festiwal Gier i Popkultury Pixel Heaven to największe w Polsce i jedno z największych w Europie corocznych wydarzeń dedykowanych branży gier wideo, na które składają się m.in. wystawa niezależnych twórców gier Pixel Expo, prezentacje, wykłady, panele oraz konkurs Pixel Awards Europe. To także unikalna otoczka, gdzie doskonale odnajdują się gracze i osoby, które pamiętają czasy pierwszych komputerów 8/16 bit, miłośnicy komiksów, gier planszowych i klimatów retro lat 80. i 90. ubiegłego wieku. Każda edycja to znakomici goście specjalni i wydarzenia towarzyszące. Podczas najbliższej edycji będa to m.in. wystawa poświęcona propagandzie w polskim komiksie czasów PRL, Mistrzostwa Polski w Tetrisie Klasycznym, turnieje w gry na Commodore Amiga oraz Mortal Kombat, trzy dni paneli, dyskusji i pokazy filmów, VR Corner, olbrzymia retro strefa komputerów i konsol 8/16 bit, wystawa Smoki i Podziemia oraz strefa rozrywki bez prądu (planszówki, komiksy).', 'jgoerzen@hotmail.com', '783920402'),
(38, 'Pendulum dj set', '2023-05-27 18:00:00', 'Warszawa', 'Praga Centrum', 500, '150', 'ELEKTRONIKA', 'Organizator: Follow The Step', 'kildjean@me.com', '938492019'),
(39, 'Ich heiße Frau Troffea', '2023-05-31 15:00:00', 'Warszawa', 'Nowy Teatr', 100, '200', 'KONCERT', 'Ich heiße Frau Troffea\r\n\r\nSergey Shabohin / Igor Shugaleev\r\n\r\nZanurzając się w historię Frau Troffea, performer opowiada o własnym doświadczeniu traumatycznej obsesji i nieustannego poszukiwania wolności.\r\n\r\nNa tydzień przed Festiwalem Marii Magdaleny w 1518 roku, Frau Troffea wyszła z domu przez podwórze i niespodziewanie dla siebie samej zaczęła gorączkowo tańczyć na jednej z wąskich strasburskich uliczek. Tańczyła cały dzień aż do późnego wieczora, a potem całą noc. Trzeciego dnia szalonego tańca była skrajnie wyczerpana, buty miała przesiąknięte krwią, ale nie mogła przestać. W końcu jej zaraźliwy taniec przetoczył się przez miasto i wywołał epidemię tańca, która przyniosła wiele ofiar.', 'crowl@optonline.net', '549203759'),
(40, 'PORTRETY 2 I koncert premierowy + jam session', '2023-05-31 16:00:00', 'Warszawa', 'Klub SPATiF', 350, '50', 'KONCERT', 'Zapraszamy na koncert premierowy albumu PORTRETY 2.\r\n\r\n31 maja ukazuje się wydawnictwo stanowiące portrety polskiej czołówki perkusyjnej. \"Pomysł na \"PORTRETY\" był prosty - zaprosić cenionych perkusistów do nagrania utworu, który będzie finalnie podpisany ich imieniem i nazwiskiem. Nie było żadnych muzycznych ram - mogli zaprosić gości lub nagrać wszystko samemu - nie trzeba było koniecznie użyć per-kusji. Tak powstały pierwsze PORTRETY w 2019, a teraz prezentujemy ich kolejną odsłonę.\"', 'fhirsch@gmail.com', '283940583');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `paymentinfo`
--

CREATE TABLE `paymentinfo` (
  `paymentInfoID` int(11) NOT NULL,
  `AssociatedUser` int(11) NOT NULL,
  `CardNumber` bigint(16) NOT NULL,
  `CardExpireDate` varchar(5) NOT NULL,
  `CardCVV` int(3) NOT NULL,
  `CardMiscDetails` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `paymentinfo`
--

INSERT INTO `paymentinfo` (`paymentInfoID`, `AssociatedUser`, `CardNumber`, `CardExpireDate`, `CardCVV`, `CardMiscDetails`) VALUES
(5, 1, 4509832905328490, '10/32', 490, 'Igor Sadło');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `personalinfo`
--

CREATE TABLE `personalinfo` (
  `PersonalInfoID` int(11) NOT NULL,
  `AssociatedUser` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Surname` varchar(100) DEFAULT NULL,
  `PhoneNumber` int(9) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Avatar` text NOT NULL DEFAULT '\'src/UserData/Avatars/default.png\'',
  `CreationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `personalinfo`
--

INSERT INTO `personalinfo` (`PersonalInfoID`, `AssociatedUser`, `Name`, `Surname`, `PhoneNumber`, `Address`, `Avatar`, `CreationDate`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '', '2023-05-19');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tickets`
--

CREATE TABLE `tickets` (
  `TicketID` int(11) NOT NULL,
  `UserWhoBought` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `TypeOfTransaction` tinytext NOT NULL,
  `TransactionPrice` int(9) NOT NULL,
  `SingleTicketsBought` int(9) NOT NULL,
  `TicketCode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Login` tinytext NOT NULL,
  `Email` tinytext NOT NULL,
  `PasswordSHA512` text NOT NULL,
  `LoginToken` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`UserID`, `Login`, `Email`, `PasswordSHA512`, `LoginToken`) VALUES
(1, 'YoungKomornik', 'wesado930@gmail.com', '4901beab3bdedb5d91f835e22545e77a286a4ef1dd0a47b05394645ac7de9581c165dd0ae37f9f211882af5da77987f494c4e5645d2bb125db930f9766487331', '87a320ce2fdbfc78b0099a117d45cb535148f4c256f1ad76b878763a9bda97674414a58c547b3ed7c620e7b0ea74075b9c140c2948d6c3fef0516ccc80190907.5fbb410b7396a34e3407a14bfe966fab743ec718ea4425e67dfc55462558e42d0aec54fd62ad1a38714e0d2da5bec13fcf4a6bc07dada917125c97c1dfd632fe');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD UNIQUE KEY `EventID` (`EventID`),
  ADD UNIQUE KEY `EventName` (`EventName`) USING HASH;

--
-- Indeksy dla tabeli `paymentinfo`
--
ALTER TABLE `paymentinfo`
  ADD PRIMARY KEY (`paymentInfoID`),
  ADD UNIQUE KEY `paymentInfoID` (`paymentInfoID`),
  ADD UNIQUE KEY `CardNumber` (`CardNumber`),
  ADD KEY `paymentInfo_fk0` (`AssociatedUser`);

--
-- Indeksy dla tabeli `personalinfo`
--
ALTER TABLE `personalinfo`
  ADD PRIMARY KEY (`PersonalInfoID`),
  ADD UNIQUE KEY `PersonalInfoID` (`PersonalInfoID`),
  ADD KEY `personalInfo_fk0` (`AssociatedUser`);

--
-- Indeksy dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `tickets_fk0` (`UserWhoBought`),
  ADD KEY `tickets_fk1` (`EventID`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD UNIQUE KEY `LoginToken` (`LoginToken`),
  ADD UNIQUE KEY `Login` (`Login`) USING HASH,
  ADD UNIQUE KEY `Email` (`Email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT dla tabeli `paymentinfo`
--
ALTER TABLE `paymentinfo`
  MODIFY `paymentInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `personalinfo`
--
ALTER TABLE `personalinfo`
  MODIFY `PersonalInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `paymentinfo`
--
ALTER TABLE `paymentinfo`
  ADD CONSTRAINT `paymentInfo_fk0` FOREIGN KEY (`AssociatedUser`) REFERENCES `user` (`UserID`);

--
-- Ograniczenia dla tabeli `personalinfo`
--
ALTER TABLE `personalinfo`
  ADD CONSTRAINT `personalinfo_ibfk_1` FOREIGN KEY (`AssociatedUser`) REFERENCES `user` (`UserID`);

--
-- Ograniczenia dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_fk0` FOREIGN KEY (`UserWhoBought`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `tickets_fk1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
