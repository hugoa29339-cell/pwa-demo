-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2025 a las 00:05:26
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_di25`
--
CREATE DATABASE IF NOT EXISTS `db_di25` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `db_di25`;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `producto` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `stock` int(7) NOT NULL,
  `precioCompra` decimal(7,2) NOT NULL,
  `precioVenta` decimal(7,2) NOT NULL,
  `stockMinimo` int(7) NOT NULL,
  `activo` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `producto`, `descripcion`, `idCategoria`, `stock`, `precioCompra`, `precioVenta`, `stockMinimo`, `activo`) VALUES
(1, '1969 Harley Davidson Ultimate Chopper', 'This replica features working kickstand, front suspension, gear-shift lever, footbrake lever, drive chain, wheels and steering. All parts are particularly delicate due to their precise scale and require special care and attention.', 5, 7933, '48.81', '95.70', 529, 'S'),
(2, '1952 Alpine Renault 1300', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 7305, '98.58', '214.30', 487, 'S'),
(3, '1996 Moto Guzzi 1100i', 'Official Moto Guzzi logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with c', 5, 6625, '68.99', '118.94', 442, 'S'),
(4, '2003 Harley-Davidson Eagle Drag Bike', 'Model features, official Harley Davidson logos and insignias, detachable rear wheelie bar, heavy diecast metal with resin parts, authentic multi-color tampo-printed graphics, separate engine drive belts, free-turning front fork, rotating tires and rear r', 5, 5582, '91.02', '193.66', 372, 'S'),
(5, '1972 Alfa Romeo GTA', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 3252, '85.68', '136.00', 217, 'S'),
(6, '1962 LanciaA Delta 16V', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 6791, '103.42', '147.74', 453, 'S'),
(7, '1968 Ford Mustang', 'Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color dark green.', 6, 68, '95.34', '194.57', 700, 'S'),
(8, '2001 Ferrari Enzo', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 3619, '95.59', '207.80', 241, 'S'),
(9, '1958 Setra Bus', 'Model features 30 windows, skylights & glare resistant glass, working steering system, original logos', 7, 1579, '77.90', '136.67', 105, 'S'),
(10, '2002 Suzuki XREO', 'Official logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with chrome accen', 5, 9997, '66.27', '150.62', 666, 'S'),
(11, '1969 Corvair Monza', '1:18 scale die-cast about 10\" long doors open, hood opens, trunk opens and wheels roll', 6, 6906, '89.14', '151.08', 460, 'S'),
(12, '1968 Dodge Charger', '1:12 scale model of a 1968 Dodge Charger. Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color black', 6, 9123, '75.16', '117.44', 608, 'S'),
(13, '1969 Ford Falcon', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 1049, '83.05', '173.02', 70, 'S'),
(14, '1970 Plymouth Hemi Cuda', 'Very detailed 1970 Plymouth Cuda model in 1:12 scale. The Cuda is generally accepted as one of the fastest original muscle cars from the 1970s. This model is a reproduction of one of the orginal 652 cars built in 1970. Red color.', 6, 5663, '31.92', '79.80', 378, 'S'),
(15, '1957 Chevy Pickup', '1:12 scale die-cast about 20\" long Hood opens, Rubber wheels', 7, 6125, '55.70', '118.50', 408, 'S'),
(16, '1969 Dodge Charger', 'Detailed model of the 1969 Dodge Charger. This model includes finely detailed interior and exterior features. Painted in red and white.', 6, 7323, '58.73', '115.16', 488, 'S'),
(17, '1940 Ford Pickup Truck', 'This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood,  removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box', 7, 2613, '58.33', '116.67', 174, 'S'),
(18, '1993 Mazda RX-7', 'This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color red.', 6, 3975, '83.51', '141.54', 265, 'S'),
(19, '1937 Lincoln Berline', 'Features opening engine cover, doors, trunk, and fuel filler cap. Color black', 1, 8693, '60.62', '102.74', 580, 'S'),
(20, '1936 Mercedes-Benz 500K Special Roadster', 'This 1:18 scale replica is constructed of heavy die-cast metal and has all the features of the original: working doors and rumble seat, independent spring suspension, detailed interior, working steering system, and a bifold hood that reveals an engine so', 1, 8635, '24.26', '53.91', 576, 'S'),
(21, '1965 Aston Martin DB5', 'Die-cast model of the silver 1965 Aston Martin DB5 in silver. This model includes full wire wheels and doors that open with fully detailed passenger compartment. In 1:18 scale, this model measures approximately 10 inches/20 cm long.', 6, 9042, '65.96', '124.44', 603, 'S'),
(22, '1980s Black Hawk Helicopter', '1:18 scale replica of actual Army\'s UH-60L BLACK HAWK Helicopter. 100% hand-assembled. Features rotating rotor blades, propeller blades and rubber wheels.', 4, 5330, '77.27', '157.69', 355, 'S'),
(23, '1917 Grand Touring Sedan', 'This 1:18 scale replica of the 1917 Grand Touring car has all the features you would expect from museum quality reproductions: all four doors and bi-fold hood opening, detailed engine and instrument panel, chrome-look trim, and tufted upholstery, all top', 1, 2724, '86.70', '170.00', 182, 'S'),
(24, '1948 Porsche 356-A Roadster', 'This precision die-cast replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel ', 6, 8826, '53.90', '77.00', 588, 'S'),
(25, '1995 Honda Civic', 'This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color yellow.', 6, 9772, '93.89', '142.25', 651, 'S'),
(26, '1998 Chrysler Plymouth Prowler', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 4724, '101.51', '163.73', 315, 'S'),
(27, '1911 Ford Town Car', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system.', 1, 540, '33.30', '60.54', 700, 'S'),
(28, '1964 Mercedes Tour Bus', 'Exact replica. 100+ parts. working steering system, original logos', 7, 8258, '74.86', '122.73', 551, 'S'),
(29, '1932 Model A Ford J-Coupe', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine', 1, 9354, '58.48', '127.13', 624, 'S'),
(30, '1926 Ford Fire Engine', 'Gleaming red handsome appearance. Everything is here the fire hoses, ladder, axes, bells, lanterns, ready to fight any inferno.', 7, 2018, '24.92', '60.77', 135, 'S'),
(31, 'P-51-D Mustang', 'Has retractable wheels and comes with a stand', 4, 992, '49.00', '84.48', 66, 'S'),
(32, '1936 Harley Davidson El Knucklehead', 'Intricately detailed with chrome accents and trim, official die-struck logos and baked enamel finish.', 5, 4357, '24.23', '60.57', 290, 'S'),
(33, '1928 Mercedes-Benz SSK', 'This 1:18 replica features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine. Color black.', 1, 548, '72.56', '168.75', 700, 'S'),
(34, '1999 Indy 500 Monte Carlo SS', 'Features include opening and closing doors. Color: Red', 6, 8164, '56.76', '132.00', 544, 'S'),
(35, '1913 Ford Model T Speedster', 'This 250 part reproduction includes moving handbrakes, clutch, throttle and foot pedals, squeezable horn, detailed wired engine, removable water, gas, and oil cans, pivoting monocle windshield, all topped with a baked enamel red finish. Each replica come', 1, 4189, '60.78', '101.31', 279, 'S'),
(36, '1934 Ford V8 Coupe', 'Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System', 1, 5649, '34.35', '62.46', 377, 'S'),
(37, '1999 Yamaha Speed Boat', 'Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 2, 4259, '51.61', '86.02', 284, 'S'),
(38, '18th Century Vintage Horse Carriage', 'Hand crafted diecast-like metal horse carriage is re-created in about 1:18 scale of antique horse carriage. This antique style metal Stagecoach is all hand-assembled with many different parts.\r\n\r\nThis collectible metal horse carriage is painted in classi', 1, 5992, '60.74', '104.72', 399, 'S'),
(39, '1903 Ford Model A', 'Features opening trunk,  working steering system', 1, 3913, '68.30', '136.59', 261, 'S'),
(40, '1992 Ferrari 360 Spider red', 'his replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 6, 8347, '77.90', '169.34', 556, 'S'),
(41, '1985 Toyota Supra', 'This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood, removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box', 6, 7733, '57.01', '107.57', 516, 'S'),
(42, 'Collectable Wooden Train', 'Hand crafted wooden toy train set is in about 1:18 scale, 25 inches in total length including 2 additional carts, of actual vintage train. This antique style wooden toy train model set is all hand-assembled with 100% wood.', 3, 6450, '67.56', '100.84', 430, 'S'),
(43, '1969 Dodge Super Bee', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 6, 1917, '49.05', '80.41', 128, 'S'),
(44, '1917 Maxwell Touring Car', 'Features Gold Trim, Full Size Spare Tire, Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System', 1, 7913, '57.54', '99.21', 528, 'S'),
(45, '1976 Ford Gran Torino', 'Highly detailed 1976 Ford Gran Torino \"Starsky and Hutch\" diecast model. Very well constructed and painted in red and white patterns.', 6, 9127, '73.49', '146.99', 608, 'S'),
(46, '1948 Porsche Type 356 Roadster', 'This model features working front and rear suspension on accurately replicated and actuating shock absorbers as well as opening engine cover, rear stabilizer flap,  and 4 opening doors.', 6, 8990, '62.16', '141.28', 599, 'S'),
(47, '1957 Vespa GS150', 'Features rotating wheels , working kick stand. Comes with stand.', 5, 7689, '32.95', '62.17', 513, 'S'),
(48, '1941 Chevrolet Special Deluxe Cabriolet', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system, leather upholstery. Color black.', 1, 2378, '64.58', '105.87', 159, 'S'),
(49, '1970 Triumph Spitfire', 'Features include opening and closing doors. Color: White.', 6, 5545, '91.92', '143.62', 370, 'S'),
(50, '1932 Alfa Romeo 8C2300 Spider Sport', 'This 1:18 scale precision die cast replica features the 6 front headlights of the original, plus a detailed version of the 142 horsepower straight 8 engine, dual spares and their famous comprehensive dashboard. Color black.', 1, 6553, '43.26', '92.03', 437, 'S'),
(51, '1904 Buick Runabout', 'Features opening trunk,  working steering system', 1, 8290, '52.66', '87.77', 553, 'S'),
(52, '1940s Ford truck', 'This 1940s Ford Pick-Up truck is re-created in 1:18 scale of original 1940s Ford truck. This antique style metal 1940s Ford Flatbed truck is all hand-assembled. This collectible 1940\'s Pick-Up truck is painted in classic dark green color, and features ro', 7, 3128, '84.76', '121.08', 209, 'S'),
(53, '1939 Cadillac Limousine', 'Features completely detailed interior including Velvet flocked drapes,deluxe wood grain floor, and a wood grain casket with seperate chrome handles', 1, 6645, '23.14', '50.31', 443, 'S'),
(54, '1957 Corvette Convertible', '1957 die cast Corvette Convertible in Roman Red with white sides and whitewall tires. 1:18 scale quality die-cast with detailed engine and underbvody. Now you can own The Classic Corvette.', 6, 1249, '69.93', '148.80', 83, 'S'),
(55, '1957 Ford Thunderbird', 'This 1:18 scale precision die-cast replica, with its optional porthole hardtop and factory baked-enamel Thunderbird Bronze finish, is a 100% accurate rendition of this American classic.', 6, 3209, '34.21', '71.27', 214, 'S'),
(56, '1970 Chevy Chevelle SS 454', 'This model features rotating wheels, working streering system and opening doors. All parts are particularly delicate due to their precise scale and require special care and attention. It should not be picked up by the doors, roof, hood or trunk.', 6, 1005, '49.24', '73.49', 67, 'S'),
(57, '1970 Dodge Coronet', '1:24 scale die-cast about 18\" long doors open, hood opens and rubber wheels', 6, 4074, '32.37', '57.80', 272, 'S'),
(58, '1997 BMW R 1100 S', 'Detailed scale replica with working suspension and constructed from over 70 parts', 5, 7003, '60.86', '112.70', 467, 'S'),
(59, '1966 Shelby Cobra 427 S/C', 'This diecast model of the 1966 Shelby Cobra 427 S/C includes many authentic details and operating parts. The 1:24 scale model of this iconic lighweight sports car from the 1960s comes in silver and it\'s own display case.', 6, 8197, '29.18', '50.31', 546, 'S'),
(60, '1928 British Royal Navy Airplane', 'Official logos and insignias', 4, 3627, '66.74', '109.42', 242, 'S'),
(61, '1939 Chevrolet Deluxe Coupe', 'This 1:24 scale die-cast replica of the 1939 Chevrolet Deluxe Coupe has the same classy look as the original. Features opening trunk, hood and doors and a showroom quality baked enamel finish.', 1, 7332, '22.57', '33.19', 489, 'S'),
(62, '1960 BSA Gold Star DBD34', 'Detailed scale replica with working suspension and constructed from over 70 parts', 5, 15, '37.32', '76.17', 700, 'S'),
(63, '18th century schooner', 'All wood with canvas sails. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with 4 masts, all square-rigged.', 2, 1898, '82.34', '122.89', 127, 'S'),
(64, '1938 Cadillac V-16 Presidential Limousine', 'This 1:24 scale precision die cast replica of the 1938 Cadillac V-16 Presidential Limousine has all the details of the original, from the flags on the front to an opening back seat compartment complete with telephone and rifle. Features factory baked-ena', 1, 2847, '20.61', '44.80', 190, 'S'),
(65, '1962 Volkswagen Microbus', 'This 1:18 scale die cast replica of the 1962 Microbus is loaded with features: A working steering system, opening front doors and tailgate, and famous two-tone factory baked enamel finish, are all topped of by the sliding, real fabric, sunroof.', 7, 2327, '61.34', '127.79', 155, 'S'),
(66, '1982 Ducati 900 Monster', 'Features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand', 5, 6840, '47.10', '69.26', 456, 'S'),
(67, '1949 Jaguar XK 120', 'Precision-engineered from original Jaguar specification in perfect scale ratio. Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent sp', 6, 2350, '47.25', '90.87', 157, 'S'),
(68, '1958 Chevy Corvette Limited Edition', 'The operating parts of this 1958 Chevy Corvette Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, working streering, opening doors and trunk. Color dark green.', 6, 2542, '15.91', '35.36', 169, 'S'),
(69, '1900s Vintage Bi-Plane', 'Hand crafted diecast-like metal bi-plane is re-created in about 1:24 scale of antique pioneer airplane. All hand-assembled with many different parts. Hand-painted in classic yellow and features correct markings of original airplane.', 4, 5942, '34.25', '68.51', 396, 'N'),
(70, '1952 Citroen-15CV', 'Precision crafted hand-assembled 1:18 scale reproduction of the 1952 15CV, with its independent spring suspension, working steering system, opening doors and hood, detailed engine and instrument panel, all topped of with a factory fresh baked enamel fini', 6, 1452, '72.82', '117.44', 97, 'S'),
(71, '1982 Lamborghini Diablo', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 6, 7723, '16.24', '37.76', 515, 'S'),
(72, '1912 Ford Model T Delivery Wagon', 'This model features chrome trim and grille, opening hood, opening doors, opening trunk, detailed engine, working steering system. Color white.', 1, 9173, '46.91', '88.51', 612, 'S'),
(73, '1969 Chevrolet Camaro Z28', '1969 Z/28 Chevy Camaro 1:24 scale replica. The operating parts of this limited edition 1:24 scale diecast model car 1969 Chevy Camaro Z28- hood, trunk, wheels, streering, suspension and doors- are particularly delicate due to their precise scale and requ', 6, 4695, '50.51', '85.61', 313, 'S'),
(74, '1971 Alpine Renault 1600s', 'This 1971 Alpine Renault 1600s replica Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked ', 6, 7995, '38.58', '61.23', 533, 'S'),
(75, '1937 Horch 930V Limousine', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system', 1, 2902, '26.30', '65.75', 193, 'S'),
(76, '2002 Chevy Corvette', 'The operating parts of this limited edition Diecast 2002 Chevy Corvette 50th Anniversary Pace car Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, poseable streering, o', 6, 9446, '62.11', '107.08', 630, 'S'),
(77, '1940 Ford Delivery Sedan', 'Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System. Color black.', 1, 6621, '48.64', '83.86', 441, 'S'),
(78, '1956 Porsche 356A Coupe', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6, 6600, '98.30', '140.43', 440, 'S'),
(79, 'Corsair F4U ( Bird Cage)', 'Has retractable wheels and comes with a stand. Official logos and insignias.', 4, 6812, '29.34', '68.24', 454, 'S'),
(80, '1936 Mercedes Benz 500k Roadster', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system and rubber wheels. Color black.', 1, 2081, '21.75', '41.03', 139, 'S'),
(81, '1992 Porsche Cayenne Turbo Silver', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 6, 6582, '69.78', '118.28', 439, 'S'),
(82, '1936 Chrysler Airflow', 'Features opening trunk,  working steering system. Color dark green.', 1, 4710, '57.46', '97.39', 314, 'S'),
(83, '1900s Vintage Tri-Plane', 'Hand crafted diecast-like metal Triplane is Re-created in about 1:24 scale of antique pioneer airplane. This antique style metal triplane is all hand-assembled with many different parts.', 4, 2756, '36.23', '72.45', 184, 'N'),
(84, '1961 Chevrolet Impala', 'This 1:18 scale precision die-cast reproduction of the 1961 Chevrolet Impala has all the features-doors, hood and trunk that open; detailed 409 cubic-inch engine; chrome dashboard and stick shift, two-tone interior; working steering system; all topped of', 6, 7869, '32.33', '80.84', 525, 'S'),
(85, '1980?s GM Manhattan Express', 'This 1980?s era new look Manhattan express is still active, running from the Bronx to mid-town Manhattan. Has 35 opeining windows and working lights. Needs a battery.', 7, 5099, '53.93', '96.31', 340, 'S'),
(86, '1997 BMW F650 ST', 'Features official die-struck logos and baked enamel finish. Comes with stand.', 5, 178, '66.92', '99.89', 700, 'S'),
(87, '1982 Ducati 996 R', 'Features rotating wheels , working kick stand. Comes with stand.', 5, 9241, '24.14', '40.23', 616, 'S'),
(88, '1954 Greyhound Scenicruiser', 'Model features bi-level seating, 50 windows, skylights & glare resistant glass, working steering system, original logos', 7, 2874, '25.98', '54.11', 192, 'S'),
(89, '1950\'s Chicago Surface Lines Streetcar', 'This streetcar is a joy to see. It has 80 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and ', 3, 8601, '26.72', '62.14', 573, 'S'),
(90, '1996 Peterbilt 379 Stake Bed with Outrigger', 'This model features, opening doors, detailed engine, working steering, tinted windows, detailed interior, die-struck logos, removable stakes operating outriggers, detachable second trailer, functioning 360-degree self loader, precision molded resin trail', 7, 814, '33.61', '64.64', 54, 'S'),
(91, '1928 Ford Phaeton Deluxe', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system', 1, 136, '33.02', '68.79', 700, 'S'),
(92, '1974 Ducati 350 Mk3 Desmo', 'This model features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand', 5, 3341, '56.13', '102.05', 223, 'S'),
(93, '1930 Buick Marquette Phaeton', 'Features opening trunk,  working steering system', 1, 7062, '27.06', '43.64', 471, 'S'),
(94, 'Diamond T620 Semi-Skirted Tanker', 'This limited edition model is licensed and perfectly scaled for Lionel Trains. The Diamond T620 has been produced in solid precision diecast and painted with a fire baked enamel finish. It comes with a removable tanker and is a perfect model to add authe', 7, 1016, '68.29', '115.75', 68, 'S'),
(95, '1962 City of Detroit Streetcar', 'This streetcar is a joy to see. It has 99 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and ', 3, 1645, '37.49', '58.58', 110, 'S'),
(96, '2002 Yamaha YZR M1', 'Features rotating wheels , working kick stand. Comes with stand.', 5, 600, '34.17', '81.36', 700, 'S'),
(97, 'The Schooner Bluenose', 'All wood with canvas sails. Measures 31 1/2 inches in Length, 22 inches High and 4 3/4 inches Wide. Many extras.\r\nThe schooner Bluenose was built in Nova Scotia in 1921 to fish the rough waters off the coast of Newfoundland. Because of the Bluenose racin', 2, 1897, '34.00', '66.67', 126, 'S'),
(98, 'American Airlines: B767-300', 'Exact replia with official logos and insignias and retractable wheels', 4, 5841, '51.15', '91.34', 389, 'S'),
(99, 'The Mayflower', 'Measures 31 1/2 inches Long x 25 1/2 inches High x 10 5/8 inches Wide\r\nAll wood with canvas sail. Extras include long boats, rigging, ladders, railing, anchors, side cannons, hand painted, etc.', 2, 737, '43.30', '86.61', 49, 'S'),
(100, 'HMS Bounty', 'Measures 30 inches Long x 27 1/2 inches High x 4 3/4 inches Wide. \r\nMany extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 2, 3501, '39.83', '90.52', 233, 'S'),
(101, 'America West Airlines B757-200', 'Official logos and insignias. Working steering system. Rotating jet engines', 4, 9653, '68.80', '99.72', 644, 'S'),
(102, 'The USS Constitution Ship', 'All wood with canvas sails. Measures 31 1/2\" Length x 22 3/8\" High x 8 1/4\" Width. Extras include 4 boats on deck, sea sprite on bow, anchors, copper railing, pilot houses, etc.', 2, 7083, '33.97', '72.28', 472, 'S'),
(103, '1982 Camaro Z28', 'Features include opening and closing doors. Color: White. \r\nMeasures approximately 9 1/2\" Long.', 6, 6934, '46.53', '101.15', 462, 'S'),
(104, 'ATA: B757-300', 'Exact replia with official logos and insignias and retractable wheels', 4, 7106, '59.33', '118.65', 474, 'S'),
(105, 'F/A 18 Hornet 1/72', '10\" Wingspan with retractable landing gears.Comes with pilot', 4, 551, '54.40', '80.00', 700, 'S'),
(106, 'The Titanic', 'Completed model measures 19 1/2 inches long, 9 inches high, 3inches wide and is in barn red/black. All wood and metal.', 2, 1956, '51.09', '100.17', 130, 'S'),
(107, 'The Queen Mary', 'Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 2, 5088, '53.63', '99.31', 339, 'S'),
(108, 'American Airlines: MD-11S', 'Polished finish. Exact replia with official logos and insignias and retractable wheels', 4, 8820, '36.27', '74.03', 588, 'S'),
(109, 'Boeing X-32A JSF', '10\" Wingspan with retractable landing gears.Comes with pilot', 4, 4857, '32.77', '49.66', 324, 'S'),
(110, 'Pont Yacht', 'Measures 38 inches Long x 33 3/4 inches High. Includes a stand.Many extras including rigging, long boats, pilot house, anchors, etc. Comes with 2 masts, all square-rigged', 7, 414, '33.30', '54.60', 700, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

CREATE TABLE `productos_categorias` (
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `activo` char(1) COLLATE latin1_spanish_ci DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos_categorias`
--

INSERT INTO `productos_categorias` (`idCategoria`, `categoria`, `descripcion`, `activo`) VALUES
(1, 'Coches Vintage', 'Nuestros modelos de coches vintage realista retratan automóviles producidos a partir de principios de 1900 hasta la década de 1940. Los materiales utilizados son de baquelita, fundición, plástico y madera. La mayorí­a de las réplicas se encuentran e', 'S'),
(2, 'Barcos', 'El día de fiesta o un regalo perfecto del aniversario para los ejecutivos, clientes, amigos y familiares. Estos modelos de barcos artesanales son, impresionantes obras de arte únicas que será atesorado durante generaciones! Vienen totalmente ensamblados y', 'S'),
(3, 'Trenes', 'Los trenes del modelo son un pasatiempo gratificante para los aficionados de todas las edades. Ya sea que usted está buscando para los trenes de colección de madera, tranvías eléctricos o locomotoras, encontrará un gran número de opciones para cualquier p', 'S'),
(4, 'Aviones', 'Unique, avión miniaturas y reproducciones de helicópteros adecuados para las colecciones, así como el hogar, la oficina o decoraciones aula. Modelos contienen detalles impresionantes como logotipos e insignias oficiales, girar los motores a reacción y hél', 'S'),
(5, 'Motocicletas', 'Las motocicletas son el estado de las réplicas del arte de los clásicos, así como leyendas de motocicletas contemporáneas como Harley Davidson, Ducati y Vespa. Modelos contienen detalles impresionantes como logotipos oficiales, ruedas giratorias, pata de ', 'S'),
(6, 'Coches clásicos', 'Los entusiastas del coche Atención: Haga que sus sueños más salvajes propiedad de automóviles se hagan realidad. Si usted está buscando para los coches clásicos del músculo, sueño coches deportivos o miniaturas película de inspiración, encontrará excelent', 'S'),
(7, 'Camiones y Autobuses', 'Los modelos de camiones y autobuses son réplicas realistas de buses y camiones especializados producidos a partir de la década de 1920 hasta la actualidad. Los modelos varían en tamaño desde 1:12 a escala 1:50 e incluyen numerosos edición limitada y vario', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(40) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `apellido1` varchar(40) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `apellido2` varchar(40) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `fechaAlta` date DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `movil` varchar(15) NOT NULL DEFAULT '',
  `login` varchar(40) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `pass` varchar(32) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `activo` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `apellido1`, `apellido2`, `sexo`, `fechaAlta`, `mail`, `movil`, `login`, `pass`, `activo`) VALUES
(1, 'visitante', 'consulta', '', 'H', '2020-10-01', 'visitante@2si.com', '976466599', 'visitante', '202cb962ac59075b964b07152d234b70', 'S'),
(2, 'admin', 'ad', 'ad', 'H', '2020-10-02', 'adminad@2si.com', '976466590', 'admin', '202cb962ac59075b964b07152d234b70', 'S'),
(7, 'Maria', 'Fernandez', 'Castro', 'H', '0000-00-00', 'MariaFernandez@2si.com', '2342423', 'safdfa', 'e10adc3949ba59abbe56e057f20f883e', 'S'),
(8, 'Felipe', 'Smit', 'Fernandez', 'H', '2020-11-23', 'FelipeSmit@2si.com', '976466599', 'fperez', 'e10adc3949ba59abbe56e057f20f883e', 'S'),
(103, 'Carine ', 'Schmitt', '', 'M', '2020-02-15', 'Carine Schmitt@2si.com', '64103103', 'Schmitt', '202cb962ac59075b964b07152d234b70', 'S'),
(112, 'Jean', 'King', '', 'H', '2020-02-15', 'JeanKing@2si.com', '64112112', 'King', '202cb962ac59075b964b07152d234b70', 'S'),
(114, 'Peter', 'Ferguson', '', 'H', '2020-02-15', 'PeterFerguson@2si.com', '64114114', 'Ferguson', '202cb962ac59075b964b07152d234b70', 'S'),
(119, 'Janine ', 'Labrune', '', 'M', '2020-02-15', 'Janine Labrune@2si.com', '64119119', 'Labrune', '202cb962ac59075b964b07152d234b70', 'S'),
(121, 'Jonas ', 'Bergulfsen', '', 'H', '2020-02-15', 'Jonas Bergulfsen@2si.com', '64121121', 'Bergulfsen', '202cb962ac59075b964b07152d234b70', 'S'),
(124, 'Susan', 'Nelson', '', 'H', '2020-02-15', 'SusanNelson@2si.com', '64124124', 'Nelson', '202cb962ac59075b964b07152d234b70', 'S'),
(125, 'Zbyszek ', 'Piestrzeniewicz', '', 'H', '2020-02-15', 'Zbyszek Piestrzeniewicz@2si.com', '64125125', 'Piestrzeniewicz', '202cb962ac59075b964b07152d234b70', 'N'),
(128, 'Roland', 'Keitel', '', 'H', '2020-02-15', 'RolandKeitel@2si.com', '64128128', 'Keitel', '202cb962ac59075b964b07152d234b70', 'S'),
(129, 'Julie', 'Murphy', '', 'M', '2020-02-15', 'JulieMurphy@2si.com', '64129129', 'Murphy', '202cb962ac59075b964b07152d234b70', 'S'),
(131, 'Kwai', 'Lee', '', 'H', '2020-02-15', 'KwaiLee@2si.com', '64131131', 'Lee', '202cb962ac59075b964b07152d234b70', 'N'),
(141, 'Diego ', 'Freyre', '', 'H', '2020-02-15', 'Diego Freyre@2si.com', '64141141', 'Freyre', '202cb962ac59075b964b07152d234b70', 'S'),
(144, 'Christina ', 'Berglund', '', 'M', '2020-02-15', 'Christina Berglund@2si.com', '64144144', 'Berglund', '202cb962ac59075b964b07152d234b70', 'N'),
(145, 'Jytte ', 'Petersen', '', 'H', '2020-02-15', 'Jytte Petersen@2si.com', '64145145', 'Petersen', '202cb962ac59075b964b07152d234b70', 'S'),
(146, 'Mary ', 'Saveley', '', 'M', '2020-02-15', 'Mary Saveley@2si.com', '64146146', 'Saveley', '202cb962ac59075b964b07152d234b70', 'S'),
(148, 'Eric', 'Natividad', '', 'H', '2020-02-15', 'EricNatividad@2si.com', '64148148', 'Natividad', '202cb962ac59075b964b07152d234b70', 'N'),
(151, 'Jeff', 'Young', '', 'H', '2020-02-15', 'JeffYoung@2si.com', '64151151', 'Young', '202cb962ac59075b964b07152d234b70', 'S'),
(157, 'Kelvin', 'Leong', '', 'H', '2020-02-15', 'KelvinLeong@2si.com', '64157157', 'Leong', '202cb962ac59075b964b07152d234b70', 'S'),
(161, 'Juri', 'Hashimoto', '', 'H', '2020-02-15', 'JuriHashimoto@2si.com', '64161161', 'Hashimoto', '202cb962ac59075b964b07152d234b70', 'S'),
(166, 'Wendy', 'Victorino', '', 'M', '2020-02-15', 'WendyVictorino@2si.com', '64166166', 'Victorino', '202cb962ac59075b964b07152d234b70', 'S'),
(167, 'Veysel', 'Oeztan', '', 'H', '2020-02-15', 'VeyselOeztan@2si.com', '64167167', 'Oeztan', '202cb962ac59075b964b07152d234b70', 'N'),
(168, 'Keith', 'Franco', '', 'H', '2020-02-15', 'KeithFranco@2si.com', '64168168', 'Franco', '202cb962ac59075b964b07152d234b70', 'S'),
(169, 'Isabel ', 'de Castro', '', 'M', '2020-02-15', 'Isabel de Castro@2si.com', '64169169', 'de Castro', '202cb962ac59075b964b07152d234b70', 'S'),
(171, 'Martine ', 'Ranc', '', 'H', '2020-02-15', 'Martine Ranc@2si.com', '64171171', 'Ranc', '202cb962ac59075b964b07152d234b70', 'S'),
(172, 'Marie', 'Bertrand', '', 'M', '2020-02-15', 'MarieBertrand@2si.com', '64172172', 'Bertrand', '202cb962ac59075b964b07152d234b70', 'N'),
(173, 'Jerry', 'Tseng', '', 'H', '2020-02-15', 'JerryTseng@2si.com', '64173173', 'Tseng', '202cb962ac59075b964b07152d234b70', 'N'),
(175, 'Julie', 'King2', '', 'M', '2020-02-15', 'JulieKing2@2si.com', '64175175', 'King2', '202cb962ac59075b964b07152d234b70', 'S'),
(177, 'Mory', 'Kentary', '', 'H', '2020-02-15', 'MoryKentary@2si.com', '64177177', 'Kentary', '202cb962ac59075b964b07152d234b70', 'S'),
(181, 'Michael', 'Frick', '', 'H', '2020-02-15', 'MichaelFrick@2si.com', '64181181', 'Frick4', '202cb962ac59075b964b07152d234b70', 'S'),
(186, 'Matti', 'Karttunen', '', 'H', '2020-02-15', 'MattiKarttunen@2si.com', '64186186', 'Karttunen', '202cb962ac59075b964b07152d234b70', 'S'),
(187, 'Rachel', 'Ashworth', '', 'M', '2020-02-15', 'RachelAshworth@2si.com', '64187187', 'Ashworth', '202cb962ac59075b964b07152d234b70', 'S'),
(189, 'Dean', 'Cassidy', '', 'H', '2020-02-15', 'DeanCassidy@2si.com', '64189189', 'Cassidy', '202cb962ac59075b964b07152d234b70', 'S'),
(198, 'Leslie', 'Taylor', '', 'M', '2020-02-15', 'LeslieTaylor@2si.com', '64198198', 'Taylor', '202cb962ac59075b964b07152d234b70', 'S'),
(201, 'Elizabeth', 'Devon', '', 'H', '2020-02-15', 'ElizabethDevon@2si.com', '64201201', 'Devon', '202cb962ac59075b964b07152d234b70', 'S'),
(202, 'Yoshi ', 'Tamuri', '', 'H', '2020-02-15', 'Yoshi Tamuri@2si.com', '64202202', 'Tamuri', '202cb962ac59075b964b07152d234b70', 'S'),
(204, 'Miguel', 'Barajas', '', 'H', '2020-02-15', 'MiguelBarajas@2si.com', '64204204', 'Barajas', '202cb962ac59075b964b07152d234b70', 'S'),
(205, 'Julie', 'Young', '', 'M', '2020-02-15', 'JulieYoung@2si.com', '64205205', 'Young2', '202cb962ac59075b964b07152d234b70', 'S'),
(206, 'Brydey', 'Walker', '', 'H', '2020-02-15', 'BrydeyWalker@2si.com', '64206206', 'Walker', '202cb962ac59075b964b07152d234b70', 'N'),
(209, 'Fréderique ', 'Citeaux', '', 'H', '2020-02-15', 'Fréderique Citeaux@2si.com', '64209209', 'Citeaux', '202cb962ac59075b964b07152d234b70', 'S'),
(211, 'Mike', 'Gao', '', 'H', '2020-02-15', 'MikeGao@2si.com', '64211211', 'Gao', '202cb962ac59075b964b07152d234b70', 'S'),
(216, 'Eduardo ', 'Saavedra', '', 'H', '2020-02-15', 'Eduardo Saavedra@2si.com', '64216216', 'Saavedra', '202cb962ac59075b964b07152d234b70', 'N'),
(219, 'Mary', 'Young', 'y', 'M', '2020-02-15', 'MaryYoung@2si.com', '64219219', 'Young3', '202cb962ac59075b964b07152d234b70', 'S'),
(223, 'Horst ', 'Kloss', '', 'H', '2020-02-15', 'Horst Kloss@2si.com', '64223223', 'Kloss', '202cb962ac59075b964b07152d234b70', 'N'),
(227, 'Palle', 'Ibsen', '', 'H', '2020-02-15', 'PalleIbsen@2si.com', '64227227', 'Ibsen', '202cb962ac59075b964b07152d234b70', 'S'),
(233, 'Jean ', 'Fresni?re', '', 'H', '2020-02-15', 'Jean Fresni?re@2si.com', '64233233', 'Fresni?re', '202cb962ac59075b964b07152d234b70', 'S'),
(237, 'Alejandra ', 'Camino', '', 'M', '2020-02-15', 'Alejandra Camino@2si.com', '64237237', 'Camino', '202cb962ac59075b964b07152d234b70', 'S'),
(239, 'Valarie', 'Thompson', '', 'M', '2020-02-15', 'ValarieThompson@2si.com', '64239239', 'Thompson2', '202cb962ac59075b964b07152d234b70', 'S'),
(240, 'Helen ', 'Bennett', '', 'M', '2020-02-15', 'Helen Bennett@2si.com', '64240240', 'Bennett', '202cb962ac59075b964b07152d234b70', 'S'),
(242, 'Annette ', 'Roulet', '', 'M', '2020-02-15', 'Annette Roulet@2si.com', '64242242', 'Roulet', '202cb962ac59075b964b07152d234b70', 'S'),
(247, 'Renate ', 'Messner', '', 'H', '2020-02-15', 'Renate Messner@2si.com', '64247247', 'Messner', '202cb962ac59075b964b07152d234b70', 'S'),
(249, 'Paolo', 'Accorti', '', 'H', '2020-02-15', 'PaoloAccorti@2si.com', '64249249', 'accorti', '202cb962ac59075b964b07152d234b70', 'S'),
(250, 'Daniel', 'Da Silva', '', 'H', '2020-02-15', 'DanielDa Silva@2si.com', '64250250', 'Da Silva', '202cb962ac59075b964b07152d234b70', 'S'),
(256, 'Daniel ', 'Tonini', '', 'H', '2020-02-15', 'Daniel Tonini@2si.com', '64256256', 'Tonini', '202cb962ac59075b964b07152d234b70', 'S'),
(259, 'Henriette ', 'Pfalzheim', '', 'H', '2020-02-15', 'Henriette Pfalzheim@2si.com', '64259259', 'Pfalzheim', '202cb962ac59075b964b07152d234b70', 'S'),
(260, 'Elizabeth ', 'Lincoln', '', 'M', '2020-02-15', 'Elizabeth Lincoln@2si.com', '64260260', 'Lincoln', '202cb962ac59075b964b07152d234b70', 'S'),
(273, 'Peter ', 'Franken', '', 'H', '2020-02-15', 'Peter Franken@2si.com', '64273273', 'Franken', '202cb962ac59075b964b07152d234b70', 'S'),
(276, 'Anna', 'O\'Hara', '', 'M', '2020-02-15', 'AnnaO\'Hara@2si.com', '64276276', 'O\'Hara', '202cb962ac59075b964b07152d234b70', 'S'),
(278, 'Giovanni ', 'Rovelli', '', 'H', '2020-02-15', 'Giovanni Rovelli@2si.com', '64278278', 'Rovelli', '202cb962ac59075b964b07152d234b70', 'S'),
(282, 'Adrian', 'Huxley', '', 'H', '2020-02-15', 'AdrianHuxley@2si.com', '64282282', 'Huxley', '202cb962ac59075b964b07152d234b70', 'S'),
(286, 'Marta', 'Hernandez', '', 'M', '2020-02-15', 'MartaHernandez@2si.com', '64286286', 'Hernandez3', '202cb962ac59075b964b07152d234b70', 'N'),
(293, 'Ed', 'Harrison', '', 'H', '2020-02-15', 'EdHarrison@2si.com', '64293293', 'Harrison', '202cb962ac59075b964b07152d234b70', 'N'),
(298, 'Mihael', 'Holz', '', 'H', '2020-02-15', 'MihaelHolz@2si.com', '64298298', 'Holz', '202cb962ac59075b964b07152d234b70', 'S'),
(299, 'Jan', 'Klaeboe', '', 'H', '2020-02-15', 'JanKlaeboe@2si.com', '64299299', 'Klaeboe', '202cb962ac59075b964b07152d234b70', 'S'),
(303, 'Bradley', 'Schuyler', '', 'H', '2020-02-15', 'BradleySchuyler@2si.com', '64303303', 'Schuyler', '202cb962ac59075b964b07152d234b70', 'S'),
(307, 'Mel', 'Andersen', '', 'H', '2020-02-15', 'MelAndersen@2si.com', '64307307', 'Andersen', '202cb962ac59075b964b07152d234b70', 'S'),
(311, 'Pirkko', 'Koskitalo', '', 'H', '2020-02-15', 'PirkkoKoskitalo@2si.com', '64311311', 'Koskitalo', '202cb962ac59075b964b07152d234b70', 'S'),
(314, 'Catherine ', 'Dewey', '', 'H', '2020-02-15', 'Catherine Dewey@2si.com', '64314314', 'Dewey', '202cb962ac59075b964b07152d234b70', 'S'),
(319, 'Steve', 'Frick', '', 'H', '2020-02-15', 'SteveFrick@2si.com', '64319319', 'Frick2', '202cb962ac59075b964b07152d234b70', 'S'),
(320, 'Wing', 'Huang', '', 'H', '2020-02-15', 'WingHuang@2si.com', '64320320', 'Huang', '202cb962ac59075b964b07152d234b70', 'S'),
(321, 'Julie', 'Brown', '', 'M', '2020-02-15', 'JulieBrown@2si.com', '64321321', 'Brown', '202cb962ac59075b964b07152d234b70', 'S'),
(323, 'Mike', 'Graham', '', 'H', '2020-02-15', 'MikeGraham@2si.com', '64323323', 'Graham', '202cb962ac59075b964b07152d234b70', 'S'),
(324, 'Ann ', 'Brown', '', 'M', '2020-02-15', 'Ann Brown@2si.com', '64324324', 'Brown2', '202cb962ac59075b964b07152d234b70', 'S'),
(328, 'William', 'Brown', '', 'H', '2020-02-15', 'WilliamBrown@2si.com', '64328328', 'Brown3', '202cb962ac59075b964b07152d234b70', 'S'),
(333, 'Ben', 'Calaghan', '', 'H', '2020-02-15', 'BenCalaghan@2si.com', '64333333', 'Calaghan', '202cb962ac59075b964b07152d234b70', 'S'),
(334, 'Kalle', 'Suominen', '', 'H', '2020-02-15', 'KalleSuominen@2si.com', '64334334', 'Suominen', '202cb962ac59075b964b07152d234b70', 'S'),
(335, 'Philip ', 'Cramer', '', 'H', '2020-02-15', 'Philip Cramer@2si.com', '64335335', 'Cramer', '202cb962ac59075b964b07152d234b70', 'S'),
(339, 'Francisca', 'Cervantes', '', 'M', '2020-02-15', 'FranciscaCervantes@2si.com', '64339339', 'Cervantes', '202cb962ac59075b964b07152d234b70', 'S'),
(344, 'Jesus', 'Fernandez', '', 'H', '2020-02-15', 'JesusFernandez@2si.com', '64344344', 'Fernandez', '202cb962ac59075b964b07152d234b70', 'S'),
(347, 'Brian', 'Chandler', '', 'H', '2020-02-15', 'BrianChandler@2si.com', '64347347', 'Chandler', '202cb962ac59075b964b07152d234b70', 'S'),
(348, 'Patricia ', 'McKenna', '', 'M', '2020-02-15', 'Patricia McKenna@2si.com', '64348348', 'McKenna', '202cb962ac59075b964b07152d234b70', 'S'),
(350, 'Laurence ', 'Lebihan', '', 'H', '2020-02-15', 'Laurence Lebihan@2si.com', '64350350', 'Lebihan', '202cb962ac59075b964b07152d234b70', 'N'),
(353, 'Paul ', 'Henriot', '', 'H', '2020-02-15', 'Paul Henriot@2si.com', '64353353', 'Henriot', '202cb962ac59075b964b07152d234b70', 'S'),
(356, 'Armand', 'Kuger', '', 'H', '2020-02-15', 'ArmandKuger@2si.com', '64356356', 'Kuger', '202cb962ac59075b964b07152d234b70', 'S'),
(357, 'Wales', 'MacKinlay', '', 'H', '2020-02-15', 'WalesMacKinlay@2si.com', '64357357', 'MacKinlay', '202cb962ac59075b964b07152d234b70', 'S'),
(361, 'Karin', 'Josephs', '', 'H', '2020-02-15', 'KarinJosephs@2si.com', '64361361', 'Josephs', '202cb962ac59075b964b07152d234b70', 'S'),
(362, 'Juri', 'Yoshido', '', 'H', '2020-02-15', 'JuriYoshido@2si.com', '64362362', 'Yoshido', '202cb962ac59075b964b07152d234b70', 'N'),
(363, 'Dorothy', 'Young', '', 'M', '2020-02-15', 'DorothyYoung@2si.com', '64363363', 'Young4', '202cb962ac59075b964b07152d234b70', 'S'),
(369, 'Lino ', 'Rodriguez', '', 'H', '2020-02-15', 'Lino Rodriguez@2si.com', '64369369', 'Rodriguez', '202cb962ac59075b964b07152d234b70', 'S'),
(376, 'Braun', 'Urs', '', 'H', '2020-02-15', 'BraunUrs@2si.com', '64376376', 'Urs', '202cb962ac59075b964b07152d234b70', 'S'),
(379, 'Allen', 'Nelson', '', 'H', '2020-02-15', 'AllenNelson@2si.com', '64379379', 'Nelson2', '202cb962ac59075b964b07152d234b70', 'S'),
(381, 'Pascale ', 'Cartrain', '', 'H', '2020-02-15', 'Pascale Cartrain@2si.com', '64381381', 'Cartrain', '202cb962ac59075b964b07152d234b70', 'S'),
(382, 'Georg ', 'Pipps', '', 'H', '2020-02-15', 'Georg Pipps@2si.com', '64382382', 'Pipps', '202cb962ac59075b964b07152d234b70', 'S'),
(385, 'Arnold', 'Cruz', '', 'H', '2020-02-15', 'ArnoldCruz@2si.com', '64385385', 'Cruz', '202cb962ac59075b964b07152d234b70', 'S'),
(386, 'Maurizio ', 'Moroni', '', 'H', '2020-02-15', 'Maurizio Moroni@2si.com', '64386386', 'Moroni', '202cb962ac59075b964b07152d234b70', 'S'),
(398, 'Akiko', 'Shimamura', '', 'H', '2020-02-15', 'AkikoShimamura@2si.com', '64398398', 'Shimamura', '202cb962ac59075b964b07152d234b70', 'S'),
(406, 'Dominique', 'Perrier', '', 'H', '2020-02-15', 'DominiquePerrier@2si.com', '64406406', 'Perrier', '202cb962ac59075b964b07152d234b70', 'S'),
(409, 'Rita ', 'MÍller', '', 'M', '2020-02-15', 'Rita MÍller@2si.com', '64409409', 'MIller', '202cb962ac59075b964b07152d234b70', 'S'),
(412, 'Sarah', 'McRoy', '', 'M', '2020-02-15', 'SarahMcRoy@2si.com', '64412412', 'McRoy', '202cb962ac59075b964b07152d234b70', 'S'),
(415, 'Michael', 'Donnermeyer', '', 'H', '2020-02-15', 'MichaelDonnermeyer@2si.com', '64415415', 'Donnermeyer', '202cb962ac59075b964b07152d234b70', 'S'),
(424, 'Maria', 'Hernandez', '', 'M', '2020-02-15', 'MariaHernandez@2si.com', '64424424', 'Hernandez2', '202cb962ac59075b964b07152d234b70', 'S'),
(443, 'Alexander ', 'Feuer', '', 'H', '2020-02-15', 'Alexander Feuer@2si.com', '64443443', 'Feuer', '202cb962ac59075b964b07152d234b70', 'S'),
(447, 'Dan', 'Lewis', '', 'H', '2020-02-15', 'DanLewis@2si.com', '64447447', 'Lewis', '202cb962ac59075b964b07152d234b70', 'S'),
(448, 'Martha', 'Larsson', '', 'M', '2020-02-15', 'MarthaLarsson@2si.com', '64448448', 'Larsson', '202cb962ac59075b964b07152d234b70', 'S'),
(450, 'Sue', 'Frick', '', '', '2020-02-15', 'SueFrick@2si.com', '64450450', 'Frick3', '202cb962ac59075b964b07152d234b70', 'S'),
(452, 'Roland ', 'Mendel', '', 'H', '2020-02-15', 'Roland Mendel@2si.com', '64452452', 'Mendel', '202cb962ac59075b964b07152d234b70', 'S'),
(455, 'Leslie', 'Murphy', '', 'M', '2020-02-15', 'LeslieMurphy@2si.com', '64455455', 'Murphy2', '202cb962ac59075b964b07152d234b70', 'S'),
(456, 'Yu', 'Choi', '', 'H', '2020-02-15', 'YuChoi@2si.com', '64456456', 'Choi', '202cb962ac59075b964b07152d234b70', 'S'),
(458, 'Martín ', 'Sommer', '', 'H', '2020-02-15', 'Martín Sommer@2si.com', '64458458', 'Sommer', '202cb962ac59075b964b07152d234b70', 'S'),
(459, 'Sven ', 'Ottlieb', '', 'H', '2020-02-15', 'Sven Ottlieb@2si.com', '64459459', 'Ottlieb', '202cb962ac59075b964b07152d234b70', 'S'),
(462, 'Violeta', 'Benitez', '', 'M', '2020-02-15', 'VioletaBenitez@2si.com', '64462462', 'Benitez', '202cb962ac59075b964b07152d234b70', 'S'),
(465, 'Carmen', 'Anton', '', 'H', '2020-02-15', 'CarmenAnton@2si.com', '64465465', 'Anton', '202cb962ac59075b964b07152d234b70', 'S'),
(471, 'Sean', 'Clenahan', '', 'H', '2020-02-15', 'SeanClenahan@2si.com', '64471471', 'Clenahan', '202cb962ac59075b964b07152d234b70', 'S'),
(473, 'Franco', 'Ricotti', '', 'H', '2020-02-15', 'FrancoRicotti@2si.com', '64473473', 'Ricotti', '202cb962ac59075b964b07152d234b70', 'S'),
(475, 'Steve', 'Thompson', '', 'H', '2020-02-15', 'SteveThompson@2si.com', '64475475', 'Thompson3', '202cb962ac59075b964b07152d234b70', 'S'),
(477, 'Hanna ', 'Moos', '', 'M', '2020-02-15', 'Hanna Moos@2si.com', '64477477', 'Moos', '202cb962ac59075b964b07152d234b70', 'S'),
(480, 'Alexander ', 'Semenov', '', 'H', '2020-02-15', 'Alexander Semenov@2si.com', '64480480', 'Semenov', '202cb962ac59075b964b07152d234b70', 'S'),
(481, 'Raanan', 'Altagar,G M', '', 'H', '2020-02-15', 'RaananAltagar,G M@2si.com', '64481481', 'Altagar,G M', '202cb962ac59075b964b07152d234b70', 'N'),
(484, 'José Pedro ', 'Roel', '', 'H', '2020-02-15', 'José Pedro Roel@2si.com', '64484484', 'Roel', '202cb962ac59075b964b07152d234b70', 'S'),
(486, 'Rosa', 'Salazar', '', 'M', '2020-02-15', 'RosaSalazar@2si.com', '64486486', 'Salazar', '202cb962ac59075b964b07152d234b70', 'S'),
(487, 'Sue', 'Taylor', '', 'M', '2020-02-15', 'SueTaylor@2si.com', '64487487', 'Taylor2', '202cb962ac59075b964b07152d234b70', 'S'),
(489, 'Thomas ', 'Smith', '', 'H', '2020-02-15', 'Thomas Smith@2si.com', '64489489', 'Smith', '202cb962ac59075b964b07152d234b70', 'S'),
(495, 'Valarie', 'Franco', '', 'M', '2020-02-15', 'ValarieFranco@2si.com', '64495495', 'Franco2', '202cb962ac59075b964b07152d234b70', 'S'),
(496, 'Tony', 'Snowden', '', 'H', '2020-02-15', 'TonySnowden@2si.com', '64496496', 'Snowden', '202cb962ac59075b964b07152d234b70', 'N'),
(497, 'ss', 'ss', '', 'H', '2022-12-07', 'ssss@2si.com', '', 'javier22', '25d55ad283aa400af464c76d713c07ad', 'S'),
(498, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxx', '0c0b3da4ac402bd86191d959be081114', 'S'),
(499, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxxxx', '0c0b3da4ac402bd86191d959be081114', 'S'),
(504, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxxxxy', '0c0b3da4ac402bd86191d959be081114', 'S'),
(505, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxxxxyy', '0c0b3da4ac402bd86191d959be081114', 'S'),
(506, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxxxxyyz', '0c0b3da4ac402bd86191d959be081114', 'S'),
(516, 'xxxx', 'xxxx', 'xxxx', 'H', '2023-11-09', 'xxxxxxxx@2si.com', '', 'xxxxxyyzdd', '0c0b3da4ac402bd86191d959be081114', 'S'),
(517, 'Fernando', 'Gómez', 'Fernandez', 'H', '2024-10-21', 'FernandoGómez@2si.com', '', 'fgomez', '02fae94b2a68a96e9d6c107cbf11c4f8', 'S');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
