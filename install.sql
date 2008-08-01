CREATE TABLE IF NOT EXISTS panel ( id VARCHAR(20) PRIMARY KEY, legend VARCHAR(80), startpos INT, stoppos INT, color1 VARCHAR(20), color2 VARCHAR(20));
INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('trunk', 'Trunks' , 53, 80, '10ff10', '009900');
INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('extension', 'Extensions' , 1, 40, '1010ff', '99cccc');
INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('parking', 'Parking lots' , 49, 72, 'ffff10', 'cc9933');
INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('conference', 'Conferences' , 45, 68, '006666', '00a010');
INSERT INTO `panel` ( `id` , `legend` , `startpos` , `stoppos` , `color1` , `color2` ) VALUES ('queue', 'Queues' , 41, 64, 'ff1010', 'a01000');
