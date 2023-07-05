-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 05, 2023 at 08:07 PM
-- Server version: 8.0.33-0ubuntu0.20.04.2
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kemenymag`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'Dev', '123123123'),
(2, 'Boss', 'asdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `exercise_id` int NOT NULL,
  `creator_id` int DEFAULT NULL,
  `title` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `unit_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`exercise_id`, `creator_id`, `title`, `description`, `image`, `link`, `availability`, `unit_id`) VALUES
(1, 1, 'Push-up', 'The hands are positioned under the shoulders with the elbows extended starting in a prone position. Maintaining a straight back and legs contacting the ground with the toes. The body is lowered till the upper arm is parallel to the floor. After that, turn the motion around and raise your body until your arm is fully extended.', 'db-pics/push-up.jpg', 'https://www.youtube.com/watch?v=IODxDxX7oi4&ab_channel=Calisthenicmovement', 1, 3),
(2, 4, 'Sit-up3', 'Knees bent, feet flat on the ground, lie on your back. Put your hands in a relaxed position on either side of your head.\r\nIn order to lift your body off the ground, bend your hips and waist. Put your body in the starting position by lowering it to the ground.', 'db-pics/sit-up.jpg', 'https://www.youtube.com/watch?v=1fbU_MkV7NE&ab_channel=LIVESTRONG.COM', 1, 3),
(3, 1, 'Squat', 'Stand with your feet slightly wider than hip width and your toes pointed forward.\r\nDrive your hips back while pressing your knees slightly apart and bending at the knees and ankles.\r\n Maintaining your heels and toes on the floor, stoop down while keeping your chest up and shoulders back.\r\nAim to finally reach parallel, which is achieved when the knees are at a 90-degree angle.\r\nTo go back to a standing erect position, drive your heels into the ground and straighten your legs.', 'db-pics/squat.jpg', 'https://www.youtube.com/watch?v=gsNoPYwWXeM&ab_channel=Calisthenicmovement', 1, 3),
(4, 1, 'Crunch', 'By your sides, place your hands on the ground. As you inhale, pull your abs up toward your spine. When you exhale, lift your feet off the ground and bring your knees up and in toward your chest while maintaining a 90-degree angle at the knees. To engage your abs, you should tuck your hips in.', 'db-pics/crunch.jpg', 'https://www.youtube.com/watch?v=MKmrqcoCZ-M&ab_channel=Howcast', 1, 3),
(5, 1, 'Plank', 'Starting on your hands and knees in a tabletop position, drop yourself to your forearms with your elbows stacked beneath your shoulders. Step your feet back until your shoulders and heels are in a straight line. To activate the abs, contract your core and visualize dragging your belly button toward your sternum.', 'db-pics/plank.jpg', 'https://www.youtube.com/watch?v=pSHjTRCQxIw&ab_channel=ScottHermanFitness', 1, 2),
(6, 1, 'Pull-up', 'Start by placing yourself exactly beneath a pull-up bar. Exhale after taking a breath.\r\nBend your elbows and move your upper body toward the bar until your chin is over it while contracting the muscles in your back and arms. Inhale as you reach the peak of the motion.', 'db-pics/pull-up.jpg', 'https://www.youtube.com/watch?v=eGo4IYlbE5g&ab_channel=Calisthenicmovement', 1, 3),
(7, 1, 'Weight lift', 'Warm up. Start off with smaller weights. Increase the weight gradually. Between sets, take at least 60 seconds to rest. Keep your workout brief—no more than 45 minutes. After your workout, gently stretch your muscles. Between workouts, take a day or two to recover.', 'db-pics/weight-lift.jpg', 'https://www.youtube.com/watch?v=t4A2o4Ycudw&ab_channel=getfitover40', 1, 3),
(8, 1, 'Dead lift', 'Place your midfoot under the barbell as you stand. Grab the bar with a shoulder-width hold as you stoop over. Kneel down until your shins are in contact with the bar. Straighten your lower back and raise your chest. Take a deep breath, hold it, and then rise up.\r\n', 'db-pics/dead-lift.jpg', 'https://www.youtube.com/watch?v=ytGaGIn3SjE&ab_channel=JeremyEthier', 1, 3),
(9, 1, 'Feet-up crunch', 'With your toes pointed inward so they contact, space your feet three to four inches apart. While keeping your elbows in, lightly place your hands on either side of your head. Not locking your fingers behind your head is a good tip. To better isolate your abdominal muscles, push the small of your back into the floor.', 'db-pics/fucrunch.jpg', 'https://www.youtube.com/watch?v=1yM7fDnGDQo&ab_channel=ClubZeroFitness', 1, 3),
(10, 1, 'Stretching', 'Smoothly extend your muscles without bouncing. Stretching while bouncing might damage your muscles and potentially make them more tense. Maintain your stretch. Hold each stretch for about 30 seconds while breathing normally; in trouble areas, you might need to hold for around 60 seconds.', 'db-pics/stretch.jpg', 'https://www.youtube.com/watch?v=xGzeJdiNrh8&t=52s&ab_channel=MichelleKenway', 1, 1),
(11, 1, 'Lunge', 'Place your feet hip-width apart as you stand. Step forward while bending both knees, lowering yourself until your knees are 90 degrees bent. Onto the lead leg, advance. Lifting your back leg and pushing it forward will cause your back foot to land in a lunge position in front of you as you step through and push off with both of your legs.', 'db-pics/lunge.jpg', 'https://www.youtube.com/watch?v=QOVaHwm-Q6U&ab_channel=Bowflex', 1, 3),
(12, 1, 'Leg press', 'With your heels and forefoot, push the platform away while bracing your abdominal muscles. Keep your heels level on the footplate at all times. The pad should never be moved just with the front of your foot or toes. Exhale and extend your legs while maintaining a flat back and head against the seat cushion.', 'db-pics/leg-press.jpg', 'https://www.youtube.com/watch?v=8EMbB0tCn7Q&ab_channel=GoodlifeHealthClubs', 1, 3),
(13, 1, 'Ab roller', 'Roll forward while tightening your abs. Move forward from your core while holding the bars on either side of the wheel. Until you feel like you can no longer raise yourself back up, roll your hands, arms, and body forward. Keep your abdominal engaged, your hips steady, and your lower back muscles tense.', 'db-pics/ab-roller.jpg', 'https://www.youtube.com/watch?v=dakSdrMV98M&ab_channel=MindPumpTV', 1, 3),
(14, 1, 'Running', 'Engage your core and lean forward a little from your waist. Draw your shoulders away from your ears, relax them, and lift your chest. Strides should be quick and short to save energy. Land gently, quietly, and with little impact to lessen your risk of damage.', 'db-pics/run.jpg', 'https://www.youtube.com/watch?v=_kGESn8ArrU&ab_channel=GlobalTriathlonNetwork', 1, 1),
(15, 1, 'Swimming', 'Float upright and horizontally with your body straight and in the water. your thumb downward. Thumbs pointed upward, assemble your hands in front of your shoulders. Put your arms out in front. After kicking in a circle, snap your feet together. Continue forward motion.', 'db-pics/swimming.jpg', 'https://www.youtube.com/watch?v=pFN2n7CRqhw&ab_channel=ChristianWedoy', 1, 1),
(16, 1, 'Jumping rope', 'Keep your hands at hip height as you hold the rope. Swing the rope with your wrists rotated, then jump. Jump simultaneously with both feet, sequentially with one foot, alternately with each foot, etc. Continue until the set is finished.', 'db-pics/jumping-rope.jpg', 'https://www.youtube.com/watch?v=kDOGb9C5kp0&ab_channel=JumpRopeDudes', 1, 3),
(17, 1, 'Bulgarian splitsquat', 'Standing half a meter in front of a platform that is knee high. Your toes should be on the platform as you extend your right leg back. Depending on personal inclination, the toes can be either flat or tucked in. Hips and shoulders should be square. Slowly bring the right knee to the floor while maintaining an erect posture. A 90 degree angle will be formed by the front knee. Reverse the motion, then take up your initial posture.', 'db-pics/split-squat.jpg', 'https://www.youtube.com/watch?v=2C-uNgKwPLE&ab_channel=ScottHermanFitness', 1, 3),
(19, 1, 'Bench-press', 'Arms should be shoulder height as you support your weight directly above your shoulders. Lift the weight until your upper arms are at a 45-degree angle. With your elbows out to the sides, gradually drop the weight back down to chest height. ', 'db-pics/bench-press.jpg', 'https://www.youtube.com/watch?v=gRVjAtPip0Y&ab_channel=BuffDudes', 1, 3),
(20, 1, 'Jumping jack', 'Legs should be straight and arms should be at your sides. Jump into the air while gently bending your knees. Spread your legs out so they are roughly shoulder-width apart as you jump. Over your head, extend your arms. Return to your starting position. Repeat.', 'db-pics/jumping-jack.jpg', 'https://www.youtube.com/watch?v=nGaXj3kkmrU&ab_channel=Babylon', 1, 3),
(21, 1, 'Cycling', 'Put your feet on the pedals and tuck them up. As long as you can, keep the bike balanced while it is moving. When you notice that the bike is about to tip, put one foot down to catch it before pushing off once more. Maintain a straight forward gaze.', 'db-pics/cycling.jpg', 'https://www.youtube.com/watch?v=GyLlw1CgXf8&ab_channel=ElectricBikeReview.com', 1, 1),
(22, 1, 'Single Leg Deadlift', 'With one knee slightly bent, balance yourself while holding a dumbbell in either hand.\r\nLengthen your free leg behind you as you begin to squat.\r\nOnce your torso is parallel to the ground, lower it further.\r\nRepeat with the other leg, then get back to the beginning position.', 'db-pics/single-leg-dedlift.jpg', 'https://www.youtube.com/watch?v=84hrdsHgDuQ&ab_channel=Well%2BGood', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `exercise_day`
--

CREATE TABLE `exercise_day` (
  `day_id` int NOT NULL,
  `day_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_day`
--

INSERT INTO `exercise_day` (`day_id`, `day_name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_unit`
--

CREATE TABLE `exercise_unit` (
  `unit_id` int NOT NULL,
  `unit_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_unit`
--

INSERT INTO `exercise_unit` (`unit_id`, `unit_name`) VALUES
(1, 'minutes'),
(2, 'seconds'),
(3, 'repetitions');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_programs`
--

CREATE TABLE `ongoing_programs` (
  `ongoing_id` int NOT NULL,
  `user_id` int NOT NULL,
  `program_id` int NOT NULL,
  `in_usage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_programs`
--

INSERT INTO `ongoing_programs` (`ongoing_id`, `user_id`, `program_id`, `in_usage`) VALUES
(1, 1, 4, 1),
(2, 1, 5, 1),
(3, 18, 5, 1),
(4, 1, 6, 0),
(5, 1, 2, 1),
(6, 1, 1, 0),
(7, 18, 2, 1),
(14, 1, 3, 1),
(18, 18, 4, 1),
(19, 23, 1, 1),
(20, 23, 2, 1),
(21, 23, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int NOT NULL,
  `program_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `creator_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `popularity` int NOT NULL DEFAULT '0',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `program_name`, `creator_id`, `category_id`, `popularity`, `is_hidden`) VALUES
(1, 'Josh\'s weightloss journey', 1, 5, 2, 0),
(2, 'Fruzsi\'s cardio help', 2, 1, 3, 0),
(3, 'Bruise helps you with flexibility', 3, 4, 2, 0),
(4, 'Get strong with Josh', 1, 2, 3, 0),
(5, 'Have a great balance with Bruise', 3, 3, 2, 0),
(6, 'Lose weight with Fruzsi', 2, 5, 2, 0),
(36, 'program23', 2, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `programs_exercises`
--

CREATE TABLE `programs_exercises` (
  `program_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `day_id` int NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs_exercises`
--

INSERT INTO `programs_exercises` (`program_id`, `exercise_id`, `day_id`, `count`) VALUES
(1, 1, 4, 36),
(1, 3, 1, 36),
(1, 4, 2, 45),
(1, 5, 2, 90),
(1, 6, 4, 24),
(1, 8, 1, 24),
(1, 10, 1, 20),
(1, 10, 2, 25),
(1, 10, 4, 25),
(1, 10, 5, 25),
(1, 12, 5, 33),
(1, 14, 2, 30),
(1, 14, 5, 20),
(1, 16, 1, 30),
(1, 16, 5, 45),
(1, 17, 5, 30),
(1, 19, 1, 25),
(1, 19, 4, 30),
(2, 3, 6, 30),
(2, 5, 1, 60),
(2, 5, 6, 45),
(2, 10, 1, 10),
(2, 10, 3, 10),
(2, 10, 4, 10),
(2, 10, 6, 10),
(2, 14, 1, 20),
(2, 14, 3, 45),
(2, 15, 3, 30),
(2, 15, 4, 30),
(2, 15, 6, 30),
(2, 16, 1, 50),
(2, 20, 4, 60),
(3, 3, 3, 25),
(3, 5, 3, 45),
(3, 10, 1, 30),
(3, 10, 3, 40),
(3, 10, 4, 60),
(3, 10, 6, 60),
(3, 11, 1, 20),
(3, 13, 3, 35),
(3, 14, 6, 30),
(3, 15, 4, 30),
(3, 20, 1, 25),
(3, 20, 6, 20),
(3, 21, 6, 45),
(4, 1, 1, 30),
(4, 1, 5, 30),
(4, 2, 4, 45),
(4, 3, 3, 30),
(4, 3, 5, 30),
(4, 4, 4, 45),
(4, 5, 1, 90),
(4, 6, 1, 24),
(4, 6, 5, 24),
(4, 8, 3, 24),
(4, 8, 5, 24),
(4, 9, 4, 36),
(4, 10, 7, 30),
(4, 11, 3, 30),
(4, 12, 3, 30),
(4, 13, 4, 30),
(4, 15, 4, 30),
(4, 16, 7, 60),
(4, 17, 3, 30),
(4, 19, 1, 24),
(4, 19, 5, 24),
(5, 4, 1, 26),
(5, 5, 1, 90),
(5, 8, 4, 30),
(5, 10, 5, 18),
(5, 11, 1, 26),
(5, 14, 7, 30),
(5, 15, 7, 30),
(5, 16, 4, 45),
(5, 17, 5, 30),
(5, 20, 7, 45),
(5, 22, 4, 30),
(5, 22, 5, 30),
(6, 1, 3, 40),
(6, 2, 5, 60),
(6, 3, 2, 48),
(6, 5, 4, 240),
(6, 8, 3, 32),
(6, 12, 4, 48),
(6, 14, 1, 20),
(6, 15, 6, 20),
(6, 16, 2, 100),
(6, 17, 5, 40),
(6, 20, 1, 80),
(6, 21, 6, 30),
(36, 2, 3, 30),
(36, 4, 3, 20),
(36, 5, 6, 20),
(36, 10, 4, 20),
(36, 21, 6, 20),
(36, 22, 6, 90);

-- --------------------------------------------------------

--
-- Table structure for table `program_category`
--

CREATE TABLE `program_category` (
  `category_id` int NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_category`
--

INSERT INTO `program_category` (`category_id`, `name`, `description`) VALUES
(1, 'Cardiovascular', 'Endurance exercise includes activities, where you increase your breathing and heart rate.'),
(2, 'Strength', 'Strength training helps you develop stronger muscles, which helps everyday activities feel easier.'),
(3, 'Balance', 'Balance exercises helps you with your stability, which is especially helpful for older people.'),
(4, 'Flexibility', 'Flexibility exercises help you move more freely and look around without the probability of pulling your shoulders.'),
(5, 'Weightloss', 'Weightloss training consists of doing endurance and weight training at the same time with a good diet.');

-- --------------------------------------------------------

--
-- Table structure for table `program_creators`
--

CREATE TABLE `program_creators` (
  `p_creator_id` int NOT NULL,
  `trainer_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_creators`
--

INSERT INTO `program_creators` (`p_creator_id`, `trainer_id`) VALUES
(1, 1),
(3, 3),
(4, 4),
(2, 8),
(12, 10);

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `trainer_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `trainer_password` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `gender` smallint NOT NULL,
  `phone` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `biography` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_banned` smallint DEFAULT '0',
  `active` smallint NOT NULL DEFAULT '0',
  `registration_token` char(40) COLLATE utf8mb4_general_ci NOT NULL,
  `registration_token_expiry` datetime DEFAULT NULL,
  `forgotten_password_token` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forgotten_password_expires` datetime DEFAULT NULL,
  `admin_approval` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `email`, `trainer_password`, `firstname`, `lastname`, `age`, `gender`, `phone`, `biography`, `is_banned`, `active`, `registration_token`, `registration_token_expiry`, `forgotten_password_token`, `forgotten_password_expires`, `admin_approval`) VALUES
(1, 'josht1@gmail.com', '$2y$10$NtsDSJVarX2z7qq4JvCmA.9Ua2R.1OeA/8UElb2UdW2NR3eDx3Bt6', 'Josh', 'Trejning', 23, 0, '0602345678', 'Josh Trejning, this is my biography.', 0, 1, '', '0000-00-00 00:00:00', '', NULL, 1),
(3, 'triner@gmail.com', '$2y$10$8h/Em5j2U.8eD4UkfHioNOizmFUV7d.YL9FNn7IM60D70RxWagqW2', 'Bruise', 'Knee', 44, 0, '12', 'asddsa', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 1),
(4, 'sesion@gmail.com', '$2y$10$6tyq4dIkxelfn1Rxf1QDS.xscOpGUrLgZ/Gv5EP4Az1nYe4n1QpJW', 'Sesion', 'Lesion', 32, 1, '0608123456', 'Sesion Lesion, this is my biography.', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL, 1),
(5, 'snus@gmail.com', '$2y$10$f2P0MiwN9PkGXql7.dganu2k8UN9Qu1.QOTOCk6mXBjJzLYxOF2ii', 'Suns', 'Luberg', 30, 1, '0640121451', 'Suns Luberg, this is my biography.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0),
(6, 'asddsa@go.com', '$2y$10$L30OdrIP19/KbIjWuwRf/O5hlRlE1kW1dVTDo.B8O9Wkvh.GPkb1m', 'asddsa', 'asddsa', 42, 1, '12312', '213dasd1', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL, 0),
(8, 'qwer@gmail.com', '$2y$10$NtsDSJVarX2z7qq4JvCmA.9Ua2R.1OeA/8UElb2UdW2NR3eDx3Bt6', 'Fruzsi', 'Pelda', 23, 1, '0605678912', 'Fruzsi Pelda, this is my biography.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 1),
(9, 'dsadsa2313@go.com', '$2y$10$aWzR9eKky4wwqlN/QMLdz.jhVRH5FW.RE92GWXabUH3xDNBo9kYbq', 'dsadsa2313', 'dsadsa2313', 25, 1, '0640101212', 'asd', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL, 1),
(10, 'zifolsan3@gmail.com', '$2y$10$yvrMN3aMwbuu32THxhngM.8CzG3KHe8hiyAoF0bpqNIScY3eqLRnO', 'Trejneeer', 'riner', 20, 0, '423421', 'biography, form of literature, commonly considered nonfictional, the subject of which is the life of an individual. One of the oldest forms of literaryory as well as written, oral,123', 0, 1, '', '2023-07-06 19:40:41', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `trainer_rating`
--

CREATE TABLE `trainer_rating` (
  `rating_id` int NOT NULL,
  `trainer_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer_rating`
--

INSERT INTO `trainer_rating` (`rating_id`, `trainer_id`, `user_id`, `comment`, `score`) VALUES
(1, 4, 7, '', 5),
(2, 4, 12, '', 4),
(3, 4, 11, '', 2),
(4, 5, 10, '', 3),
(7, 3, 18, 'rating1', 4),
(21, 4, 18, '  bambammamma', 1),
(23, 8, 18, '  fruzsi bestest ttrejner', 3),
(25, 4, 18, 'Great program you made loved it! <3', 5),
(26, 1, 18, '', 5),
(28, 1, 18, 'training', 3),
(29, 1, 18, 'data', 5),
(30, 3, 18, 'asd', 4),
(31, 1, 18, 'best one', 5),
(35, 1, 1, 'qweqwer', 2),
(36, 3, 1, 'comment2', 5),
(37, 1, 1, 'i love his trainings', 5),
(38, 3, 1, 'f  this guy', 1),
(39, 1, 23, 'I loved your training program about weightloss. :)', 5),
(40, 8, 23, 'not my style', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int DEFAULT NULL,
  `gender` smallint DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_banned` smallint NOT NULL DEFAULT '0',
  `active` smallint NOT NULL DEFAULT '0',
  `registration_token` char(40) COLLATE utf8mb4_general_ci NOT NULL,
  `registration_token_expiry` datetime DEFAULT NULL,
  `forgotten_password_token` char(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forgotten_password_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `user_password`, `firstname`, `lastname`, `age`, `gender`, `phone`, `is_banned`, `active`, `registration_token`, `registration_token_expiry`, `forgotten_password_token`, `forgotten_password_expires`) VALUES
(1, 'balinth3@gmail.com', '$2y$10$P1/vaCRgLpQvgGtSGTMxY.0cy8cAn7Ct14urt697jEIJq0HYsNr82', 'Bálint', 'Huszár', 20, 0, NULL, 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(2, 'ketondtry@gmail.com', '$2y$10$F5UpCwjLUAPByrVgs9TxBeb/tJ5DUKlQ.sktsgf3xHJ91sIlkmMy2', 'go', 'goo', 21, 0, NULL, 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(3, 'asd@gooasd.com', '$2y$10$NoOK9rS/H1enMHwt3XBbBO2Dghbv.tcvWqa4PDBs6MmpCcO/IJ0WK', 'asdasd', 'asdasd', 22, 0, NULL, 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(4, 'asd123@gmaio.com', '$2y$10$CgLiXLhmDFg2zqsw604wsePlBU0HkEJ6LfMbpdPW7eieJfz8QxfU6', 'eooeo', 'eooeooe', 23, 1, NULL, 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(6, 'phone@gmail.com', '$2y$10$mEJxjAlx3DL5WDuRnYzt3e5JF3H2YDNA8I.uv1FTZZHPM16NQgb7m', 'phone', 'phone', 32, 1, '32', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(7, 'exam@d.com', '$2y$10$2oTKg.BD1sBkOPw5uVJN7O1evy5jKSlnrRYh6NehCCfPkQCLNVVA.', 'exam', 'exam', 21, 0, '3231213', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(8, 'feml@g.co', '$2y$10$gu5LrrfBugQT1Ll3LTyBh.g6rZD8fbeYBOqSOhD10iwQbdUu8wY0O', 'feml', 'feml', 51, 1, '3232', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(9, 'dso@p.coo', '$2y$10$a.ufqISMWEpaYR8fgIGWd.pXSzl5Mi794GtN77Ncbbq/PTFmS2rL6', 'dsodso', 'dsodso', 32, 1, '3123', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(10, 'oooroo@gooa.co', '$2y$10$cupIBOtg.ZjC1SJnHWxRCOPoFm8SSZpuyDM5orrEcvBTsKItW5ecS', 'oooroo', 'oooroo', 32, 0, '32112', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(11, 'peldauser@gm.co', '$2y$10$MFofPcrQQ0JigFOkK/9TJ.4GesvKYxYoZFQeaLTbWsonk2lAYaUri', 'peldauser', 'peldauser', 51, 0, '123141', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(12, 'pldiii@gmover.com', '$2y$10$dzSc2oHyD1gRXmxoXvyqj.9.K2QH99/l8QGqqzMvXuP2HtKQk/znW', 'pldiii', 'pldiii', 55, 1, '12112', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(13, 'leggo@glo.com', '$2y$10$eK8heLqbRxo7t7vU9jSku.8I4ErYR.y.82Bqftrr69Y1IMJd9SsVq', 'leggo', 'leggo', 23, 0, '56', 0, 0, '8352cf805ccd2b207a7eb63f34c09927e808c932', '2023-06-24 09:21:27', NULL, NULL),
(14, 'ollo@ol.co', '$2y$10$8ir9yU7TUl4oXHoN7NKMaeDXGKBCxM6pA00LUnB4NNDfkKM.kZuWy', 'ollo', 'ollo', 51, 0, '5124', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(15, 'asd123@gmail.com', '$2y$10$egAdTdbNU5jHdLtyTtX8peMrletXbMQdrS39VYqZhM3wpD2EiklYO', 'asd123', 'asd123', 12, 0, '312', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(16, 'oadsdoaoo@owq.rer', '$2y$10$lM8ue0aFT9A7.LiPqSSRn.sBPt5OIVuFMZf46jkDeBPou6J0uu/zi', 'asd', 'asd', 53, 0, '2343123', 0, 1, '', '0000-00-00 00:00:00', NULL, NULL),
(17, 'triner1@gmail.com', '$2y$10$TmCJDTraweon2ldkcOaFqO9/kjA3AxBIEvu/gHiHd7ji3Gtyi8O52', 'tsd', 'tsd', 42, 0, '3523', 0, 1, '', '0000-00-00 00:00:00', '65b3c553063131b6bdd8491fbd67139284da91f7', '2023-06-24 13:58:57'),
(18, 'alekosz@gmail.com', '$2y$10$02QaibfYpEg9A0/AmhdAQOOOyohFGWDwMGVlnmt.tBLQbNvuueeKm', 'alekosz', 'alekosz', 51, 0, '2331', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(19, 'peldapeteruser1@gmail.com', '$2y$10$dfF2/mxC40bD9rs.4XNb4u4o9W7mqPsInB6CFlPw3y73cvjnbZpC2', 'peldapeteruser1', 'peldapeteruser1', 21, 0, '41243213', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(22, 'matkovity77@gmail.com', '$2y$10$hBMwz0Y3jKS5wVWqNuo3wOZvG4F9AkuXZKUyKgjfQgC6rDZ.Cb1RO', 'Gabor', 'Matko', 20, 0, '00645488', 0, 1, '', '2023-07-06 19:16:37', NULL, NULL),
(23, 'euwrozsgo@gmail.com', '$2y$10$UMgBvWnr3JYrJZIIav7u1u7q6A0MAcQKWTSDfQqO.RGsEcbIvFVPi', 'balint', 'balint', 24, 0, '321313', 0, 1, '', '2023-07-06 19:17:46', '', '2023-07-06 01:19:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_email_failures`
--

CREATE TABLE `user_email_failures` (
  `id_user_email_failure` int NOT NULL,
  `user_id` int NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_time_added` datetime NOT NULL,
  `date_time_tried` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_programs`
--

CREATE TABLE `user_programs` (
  `user_programs_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_hidden` smallint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_programs`
--

INSERT INTO `user_programs` (`user_programs_id`, `user_id`, `is_hidden`) VALUES
(7, 4, 0),
(43, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_programs_exercises`
--

CREATE TABLE `user_programs_exercises` (
  `upe_id` int NOT NULL,
  `user_programs_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_programs_exercises`
--

INSERT INTO `user_programs_exercises` (`upe_id`, `user_programs_id`, `exercise_id`, `count`) VALUES
(62, 43, 2, 20),
(63, 43, 2, 10),
(64, 43, 4, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`exercise_id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `exercise_day`
--
ALTER TABLE `exercise_day`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `exercise_unit`
--
ALTER TABLE `exercise_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `ongoing_programs`
--
ALTER TABLE `ongoing_programs`
  ADD PRIMARY KEY (`ongoing_id`),
  ADD KEY `ongoing_programs_ibfk_1` (`program_id`),
  ADD KEY `ongoing_programs_ibfk_2` (`user_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `programs_exercises`
--
ALTER TABLE `programs_exercises`
  ADD PRIMARY KEY (`program_id`,`exercise_id`,`day_id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `programs_exercises_ibfk_2` (`exercise_id`);

--
-- Indexes for table `program_category`
--
ALTER TABLE `program_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `program_creators`
--
ALTER TABLE `program_creators`
  ADD PRIMARY KEY (`p_creator_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `trainer_rating`
--
ALTER TABLE `trainer_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  ADD PRIMARY KEY (`id_user_email_failure`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_programs`
--
ALTER TABLE `user_programs`
  ADD PRIMARY KEY (`user_programs_id`,`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_programs_exercises`
--
ALTER TABLE `user_programs_exercises`
  ADD PRIMARY KEY (`upe_id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `user_programs_id` (`user_programs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `exercise_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `exercise_day`
--
ALTER TABLE `exercise_day`
  MODIFY `day_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exercise_unit`
--
ALTER TABLE `exercise_unit`
  MODIFY `unit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ongoing_programs`
--
ALTER TABLE `ongoing_programs`
  MODIFY `ongoing_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `program_category`
--
ALTER TABLE `program_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `program_creators`
--
ALTER TABLE `program_creators`
  MODIFY `p_creator_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `trainer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trainer_rating`
--
ALTER TABLE `trainer_rating`
  MODIFY `rating_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  MODIFY `id_user_email_failure` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_programs`
--
ALTER TABLE `user_programs`
  MODIFY `user_programs_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_programs_exercises`
--
ALTER TABLE `user_programs_exercises`
  MODIFY `upe_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercises_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `trainer` (`trainer_id`),
  ADD CONSTRAINT `exercises_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `exercise_unit` (`unit_id`);

--
-- Constraints for table `ongoing_programs`
--
ALTER TABLE `ongoing_programs`
  ADD CONSTRAINT `ongoing_programs_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ongoing_programs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `program_creators` (`p_creator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `program_category` (`category_id`);

--
-- Constraints for table `programs_exercises`
--
ALTER TABLE `programs_exercises`
  ADD CONSTRAINT `programs_exercises_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `exercise_day` (`day_id`),
  ADD CONSTRAINT `programs_exercises_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`exercise_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_exercises_ibfk_3` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_creators`
--
ALTER TABLE `program_creators`
  ADD CONSTRAINT `program_creators_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainer_rating`
--
ALTER TABLE `trainer_rating`
  ADD CONSTRAINT `trainer_rating_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`trainer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trainer_rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_email_failures`
--
ALTER TABLE `user_email_failures`
  ADD CONSTRAINT `user_email_failures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_programs`
--
ALTER TABLE `user_programs`
  ADD CONSTRAINT `user_programs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_programs_exercises`
--
ALTER TABLE `user_programs_exercises`
  ADD CONSTRAINT `user_programs_exercises_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`exercise_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_programs_exercises_ibfk_2` FOREIGN KEY (`user_programs_id`) REFERENCES `user_programs` (`user_programs_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
