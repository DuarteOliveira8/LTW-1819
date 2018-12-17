.bail ON
.mode columns
.headers on
.nullvalue NULL

PRAGMA FOREIGN_KEYS=ON;


DROP TABLE IF EXISTS SUBSCRIBER;
DROP TABLE IF EXISTS STORYUPVOTE;
DROP TABLE IF EXISTS STORYDOWNVOTE;
DROP TABLE IF EXISTS COMMENTUPVOTE;
DROP TABLE IF EXISTS COMMENTDOWNVOTE;
DROP TABLE IF EXISTS STORYCOMMENT;
DROP TABLE IF EXISTS CHAINCOMMENT;
DROP TABLE IF EXISTS COMMENT;
DROP TABLE IF EXISTS RULE;
DROP TABLE IF EXISTS STORY;
DROP TABLE IF EXISTS CHANNEL;
DROP TABLE IF EXISTS USER;



CREATE TABLE RULE (
	id		 	 			INTEGER PRIMARY KEY AUTOINCREMENT,
	description	 	STRING NOT NULL,
	idChannel	 		INTEGER REFERENCES CHANNEL(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE CHANNEL (
	id		 			INTEGER PRIMARY KEY AUTOINCREMENT,
	name		 		STRING NOT NULL UNIQUE,
	slogan	 	  STRING NOT NULL,
	banner		  STRING DEFAULT "default-background.jpg",
	idCreator	  INTEGER REFERENCES USER(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE USER (
	id		 		  INTEGER PRIMARY KEY AUTOINCREMENT,
	username	  STRING NOT NULL UNIQUE,
	firstName	  STRING NOT NULL,
	lastName	  STRING NOT NULL,
	email		    STRING NOT NULL UNIQUE,
	password	  CHAR (256) NOT NULL,
	bio		      STRING DEFAULT "",
	avatar		  STRING DEFAULT "default-profile.png",
	banner		  STRING DEFAULT "default-background.jpg",
	birthDate	  DATE NOT NULL
);

CREATE TABLE STORY (
	id		 				INTEGER PRIMARY KEY AUTOINCREMENT,
	title		 			STRING NOT NULL,
	description		STRING NOT NULL,
	upvoteRatio	 	INTEGER DEFAULT 0,
	storyDate	 		DATE NOT NULL,
	idAuthor	 		INTEGER REFERENCES USER(id) ON DELETE CASCADE NOT NULL,
	channel       INTEGER REFERENCES CHANNEL(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE COMMENT (
	id		 				INTEGER PRIMARY KEY AUTOINCREMENT,
	description		STRING NOT NULL,
	upvoteRatio	 	INTEGER DEFAULT 0,
	commentDate	 	DATE NOT NULL,
	idAuthor	 		INTEGER REFERENCES USER(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE STORYCOMMENT (
	storyId 	 	  INTEGER REFERENCES STORY(id) ON DELETE CASCADE,
	commentId    	INTEGER REFERENCES COMMENT(id) ON DELETE CASCADE,
  PRIMARY KEY 	(commentId, storyId)
);

CREATE TABLE CHAINCOMMENT (
	parentComment    INTEGER REFERENCES COMMENT(id) ON DELETE CASCADE,
  childComment 	 	INTEGER REFERENCES COMMENT(id) ON DELETE CASCADE,
  PRIMARY KEY 	(parentComment, childComment)
);

CREATE TABLE SUBSCRIBER (
	userId    	 	INTEGER REFERENCES USER(id) ON DELETE CASCADE,
  channelId 	 	INTEGER REFERENCES CHANNEL(id) ON DELETE CASCADE,
  PRIMARY KEY 	(userId, channelId)
);

CREATE TABLE STORYUPVOTE (
	storyId    	 	INTEGER REFERENCES STORY(id) ON DELETE CASCADE,
  userId			 	INTEGER REFERENCES USER(id) ON DELETE CASCADE,
  PRIMARY KEY 	(storyId, userId)
);

CREATE TABLE STORYDOWNVOTE (
	storyId    	 	INTEGER REFERENCES STORY(id) ON DELETE CASCADE,
  userId		 		INTEGER REFERENCES USER(id) ON DELETE CASCADE,
  PRIMARY KEY 	(storyId, userId)
);

CREATE TABLE COMMENTUPVOTE (
	commentId    	INTEGER REFERENCES STORY(id) ON DELETE CASCADE,
  userId			 	INTEGER REFERENCES USER(id) ON DELETE CASCADE,
  PRIMARY KEY 	(commentId, userId)
);

CREATE TABLE COMMENTDOWNVOTE (
	commentId    	INTEGER REFERENCES STORY(id) ON DELETE CASCADE,
  userId		 		INTEGER REFERENCES USER(id) ON DELETE CASCADE,
  PRIMARY KEY 	(commentId, userId)
);



DROP TRIGGER IF EXISTS CheckBeforeStoryUpvote;
DROP TRIGGER IF EXISTS CheckBeforeStoryDownvote;
DROP TRIGGER IF EXISTS CheckBeforeCommentUpvote;
DROP TRIGGER IF EXISTS CheckBeforeCommentDownvote;
DROP TRIGGER IF EXISTS AddStoryUpvote;
DROP TRIGGER IF EXISTS AddStoryDownvote;
DROP TRIGGER IF EXISTS RemoveStoryUpvote;
DROP TRIGGER IF EXISTS RemoveStoryDownvote;
DROP TRIGGER IF EXISTS AddCommentUpvote;
DROP TRIGGER IF EXISTS AddCommentDownvote;
DROP TRIGGER IF EXISTS RemoveCommentUpvote;
DROP TRIGGER IF EXISTS RemoveCommentDownvote;


CREATE TRIGGER CheckBeforeStoryUpvote
BEFORE INSERT ON STORYUPVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM STORYDOWNVOTE WHERE (STORYDOWNVOTE.storyId=NEW.storyId and STORYDOWNVOTE.userId=NEW.userId))
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio + 1 WHERE (STORY.id = NEW.storyId);
	DELETE FROM STORYDOWNVOTE WHERE (STORYDOWNVOTE.userId=NEW.userId AND STORYDOWNVOTE.storyId=NEW.storyId);
END;

CREATE TRIGGER CheckBeforeStoryDownvote
BEFORE INSERT ON STORYDOWNVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM STORYUPVOTE WHERE (STORYUPVOTE.storyId=NEW.storyId and STORYUPVOTE.userId=NEW.userId))
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio - 1 WHERE (STORY.Id = NEW.storyId);
	DELETE FROM STORYUPVOTE WHERE (STORYUPVOTE.userId=NEW.userId AND STORYUPVOTE.storyId=NEW.storyId);
END;

CREATE TRIGGER CheckBeforeCommentUpvote
BEFORE INSERT ON COMMENTUPVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM COMMENTDOWNVOTE WHERE (COMMENTDOWNVOTE.commentId=NEW.commentId and COMMENTDOWNVOTE.userId=NEW.userId))
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio + 1 WHERE (COMMENT.id = NEW.commentId);
	DELETE FROM COMMENTDOWNVOTE WHERE (COMMENTDOWNVOTE.userId=NEW.userId AND COMMENTDOWNVOTE.commentId=NEW.commentId);
END;

CREATE TRIGGER CheckBeforeCommentDownvote
BEFORE INSERT ON COMMENTDOWNVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM COMMENTUPVOTE WHERE (COMMENTUPVOTE.commentId=NEW.commentId and COMMENTUPVOTE.userId=NEW.userId))
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio - 1 WHERE (COMMENT.Id = NEW.commentId);
	DELETE FROM COMMENTUPVOTE WHERE (COMMENTUPVOTE.userId=NEW.userId AND COMMENTUPVOTE.commentId=NEW.commentId);
END;

CREATE TRIGGER AddStoryUpvote
AFTER INSERT ON STORYUPVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio + 1 WHERE (STORY.id = NEW.storyId);
END;

CREATE TRIGGER AddStoryDownvote
AFTER INSERT ON STORYDOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio - 1 WHERE (STORY.id = NEW.storyId);
END;

CREATE TRIGGER RemoveStoryUpvote
AFTER DELETE ON STORYUPVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio - 1 WHERE (STORY.id = OLD.storyId);
END;

CREATE TRIGGER RemoveStoryDownvote
AFTER DELETE ON STORYDOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET upvoteRatio = upvoteRatio + 1 WHERE (STORY.id = OLD.storyId);
END;

CREATE TRIGGER AddCommentUpvote
AFTER INSERT ON COMMENTUPVOTE
FOR EACH ROW
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio + 1 WHERE (COMMENT.id = NEW.commentId);
END;

CREATE TRIGGER AddCommentDownvote
AFTER INSERT ON COMMENTDOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio - 1 WHERE (COMMENT.id = NEW.commentId);
END;

CREATE TRIGGER RemoveCommentUpvote
AFTER DELETE ON COMMENTUPVOTE
FOR EACH ROW
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio - 1 WHERE (COMMENT.id = OLD.commentId);
END;

CREATE TRIGGER RemoveCommentDownvote
AFTER DELETE ON COMMENTDOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE COMMENT SET upvoteRatio = upvoteRatio + 1 WHERE (COMMENT.id = OLD.commentId);
END;


INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Pedro','Pedro','Gonçalves','pedro@gmail.com', '2702cb34ee041711b9df0c67a8d5c9de02110c80e3fc966ba8341456dbc9ef2b', 'Yes.', '1.jpg','1998-10-16');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('DuarteOliveira8','Duarte','Oliveira','duarte@gmail.com', 'd5b64690663f2177ef0da201b741b84cd4659fdcb7fa2e2440c4f1e4ee8b2aba', 'Inspiring baguette quote here.', '2.jpg','1998-10-16');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('MariaNeves19','Maria','Neves','maneves@gmail.com', '65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5', 'Hello.', '3.jpg','1998-08-15');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('SilvaJoao','Joao','Silva','js1982@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Hello.', '4.jpg','1994-03-15');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Peixoto98','Leonor','Peixoto','lpemail@hotmail.com', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', 'Hello.', '5.jpg','1999-09-25');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('MatildeSantos','Matilde','Santos','matildesantos@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'Hello.', '6.jpg','1998-01-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Francisco35','Francisco','Silva','fs9999@gmail.com', 'f4df5fb2a700c78a749de2d8749da8049aa2fbc831b0c8f4b790aacc2277e77d', 'Hello.', '7.jpg','1998-10-08');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('AfonsoSantos99','Afonso','Santos','afonsos@hotmail.com', '7a6cff37883086eacdae5540af9f90971c5c4bd1d43fd65ca8c3101926f38f74', 'Hello.', '8.jpg','2000-12-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('CarolFerr','Carolina','Ferreira','carolferreira@hotmail.com', 'b2e9a0574b5466acb3c5b909ee216578a8f97782ea4227679123ce41c1b3c676', 'Hello.', '9.jpg','1989-11-23');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('VascoOliveira','Vasco','Oliveira','vascooo@gmail.com', '1a5376ad727d65213a79f3108541cf95012969a0d3064f108b5dd6e7f8c19b89', 'Hello.', '10.jpg','1998-08-23');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('FranciscoFilipe','Francisco','Filipe','canelas@gmail.com', 'bf1474f5cdab99f709259e2c800bdba9cdb2ff0fbbed42ede3a4dfd5fd6232c2', 'Hello.', '11.jpg','1999-08-05');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Maregol','Moussa','Marega','marega@hotmail.com', 'e094461145afaf76c97e96a7d9542c0b4f9eed158da7338c29a8400fa6d4ab3d', 'Hello.', '12.jpg','1989-09-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('CrisFCP12','Cristina','Ferreira','cristi@hotmail.com', 'aca3af4252fe6f0d2413b2209af5212eef17162c227d5563a86fc9fd7e82cffa', 'Hello.', '13.jpg','2005-12-31');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Matilde12','Matilde','Santos','matildesantos12@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'Hello.', '14.jpg','2012-12-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Kibangas','Duarte','Faria','fariola@gmail.com', 'e7a94865bf232c9b3ee56bca7bf2ad76faa5887cb9e5a4b176446da4a27c1420', 'Hello.', '15.jpg','1999-02-18');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('DiogoLuisXX','Diogo','Luis','xxluisxx@hotmail.com', '4dcab0d82ccb503fea0f6f7a4d63440981cf2755d9fba55733489e8c8091fdf5', 'Hello.', '16.jpg','1997-08-30');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Anterabyte','Antero','Santos','antero@hotmail.com', '5ccc2e8715d7a17c3110afe37b8561b84b450db8efcf187d90649f212201050f', 'Hello.', '17.jpg','1996-10-08');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Championships','Meek','Mill','meekmilly@gmail.com', '932f3c1b56257ce8539ac269d7aab42550dacf8818d075f0bdf1990562aae3ef', 'Hello.', '18.jpg','1987-03-12');


INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('Advice','This is a place where you can ask for advice on any subject', 1, '1.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('Music','Insert your favourite musics in this place so we can discuss it.', 2, '2.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('Funny','Welcome to Funny: Webbits largest humour depository', 1, '3.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('School','Insert your doubts about school subjects.', 10, '4.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('Quotes','For your favorite quotes. Current quotes, historic quotes, movie quotes, song lyric quotes,...', 2, '5.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('Sports','Watch out for news about your favourite sports', 1, '6.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('E-Sports','News about the best e-sport scenes', 2, '7.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('CursedImages','Cursed slogan', 2, '8.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('DankMemes','Very dankerino', 2, '9.jpg');
INSERT INTO CHANNEL (name, slogan, idCreator, banner) VALUES ('TIFU',"Today I F'd up", 2, '10.jpg');

INSERT INTO RULE (description, idChannel) VALUES ('Be Nice.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('Posts must ask for advice.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('Avoid topics requiring specific expertise.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('Follow the rules of society.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('Post template: Artist - Title [Genre].', 2);
INSERT INTO RULE (description, idChannel) VALUES ('No leaks or piracy.', 2);
INSERT INTO RULE (description, idChannel) VALUES ('No crowdfunding sites.', 2);
INSERT INTO RULE (description, idChannel) VALUES ('No posts unrelated to music.', 2);
INSERT INTO RULE (description, idChannel) VALUES ('All posts must make an attempt at humor.', 3);
INSERT INTO RULE (description, idChannel) VALUES ('No Reposts.', 3);
INSERT INTO RULE (description, idChannel) VALUES ('No Politics.', 3);
INSERT INTO RULE (description, idChannel) VALUES ('No Dark Jokes.', 3);
INSERT INTO RULE (description, idChannel) VALUES ('No Hate.', 4);
INSERT INTO RULE (description, idChannel) VALUES ('Be Nice.', 4);
INSERT INTO RULE (description, idChannel) VALUES ('Keep things SFW.', 4);
INSERT INTO RULE (description, idChannel) VALUES ('No Reposts.', 5);
INSERT INTO RULE (description, idChannel) VALUES ('No Low-effort posts.', 6);
INSERT INTO RULE (description, idChannel) VALUES ('No spam.', 6);
INSERT INTO RULE (description, idChannel) VALUES ('No Illegal Content.', 6);
INSERT INTO RULE (description, idChannel) VALUES ('No Rudeness or Flame Bait.', 6);
INSERT INTO RULE (description, idChannel) VALUES ('No Surveys/Research Projects.', 7);
INSERT INTO RULE (description, idChannel) VALUES ('No Posts unrelated to E-Sports.', 7);
INSERT INTO RULE (description, idChannel) VALUES ('No Raffles/Giveaways.', 7);
INSERT INTO RULE (description, idChannel) VALUES ('All posts must have "cursed_" in the title.', 8);
INSERT INTO RULE (description, idChannel) VALUES ('No Nudity.', 8);
INSERT INTO RULE (description, idChannel) VALUES ('No Racism/Hate Speech.', 8);
INSERT INTO RULE (description, idChannel) VALUES ('Keep it cursed.', 8);
INSERT INTO RULE (description, idChannel) VALUES ('No Hate Speech.', 9);
INSERT INTO RULE (description, idChannel) VALUES ('Only post original content.', 9);
INSERT INTO RULE (description, idChannel) VALUES ('No spam.', 9);
INSERT INTO RULE (description, idChannel) VALUES ('Keep it Dank.', 9);
INSERT INTO RULE (description, idChannel) VALUES ('All titles must start with TIFU.', 10);
INSERT INTO RULE (description, idChannel) VALUES ('All content must be your own.', 10);
INSERT INTO RULE (description, idChannel) VALUES ('No personal info.', 10);
INSERT INTO RULE (description, idChannel) VALUES ('No bots/advertising.', 10);

--1 to 10
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Im about to tell my boss that I stole almost $5000','No one even has a clue the money is missing but I just cant hide it anymore.... I just posted this to vent and maybe help with my anxiety','2018-11-30',3,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What are schools called that i can attend in holidays.','I live in Melbourne and am seriously falling behind in work. I was wondering what are the schools called that I can attend in the holidays so I can catch up on work.','2018-11-20',5,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy XBOX or PS4?','What are the pros and cons of each one?','2018-12-01',4,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy a laptop or a desktop computer?','What are the pros and cons of each one?','2018-12-02',5,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy OnePlus or Google Pixel?','What are the pros and cons of each one?','2018-12-03',6,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy Luso or Fastio?','What are the pros and cons of each one?','2018-12-04',7,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy Pepsi or Coke?','What are the pros and cons of each one?','2018-12-05',8,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy Asus or Acer?','What are the pros and cons of each one?','2018-12-06',9,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy Alienware or Dell?','What are the pros and cons of each one?','2018-12-07',10,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Should I buy FEUP or ISEP?','What are the pros and cons of each one?','2018-12-08',11,0,1);

--11 to 20
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What do you think about Logics new album?','Its my favourite album of the year tbh.','2018-09-20',2,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TWICE - YES or YES [K-POP]','What do you think about it?','2018-09-22',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fox Stevenson - Sandblast [Glitch Hop]','What do you think about it?','2018-10-03',2,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Porter Robinson & Madeon - Shelter [Electronic]','What do you think about it?','2018-10-05',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Alan Walker - Faded [Electronic]','What do you think about it?','2018-10-20',4,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Eddie Vedder - Society [Alternative Rock]','What do you think about it?','2018-10-21',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Nirvana - Come As You Are [Grunge]','What do you think about it?','2018-11-15',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Mumford and Sons - Believe [Indie]','What do you think about it?','2018-12-10',15,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Nujabes - Feather [Jazzhop]','What do you think about it?','2018-09-20',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('How about dat','Cash me outside.','2018-05-26',12,0,2);

--21 to 30
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('You Are Living Proof That God Has A Sense Of Humor','True Story.','2018-11-05',6,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I think you are cool','NOT.','2018-06-07',11,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Hey Dad, who invented the haircut?','I don’t know, but I’m sure it was some barberian.','2018-06-27',5,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What’s the least spoken language in the world?','Sign language.','2018-07-17',11,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Growing up, my teachers told me I was worthless and would never amount to anything in life.','Being homeschooled sucks.','2018-08-07',5,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('The sun doesnt have to go to college because','It already has 28 million degrees.','2018-08-27',11,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Ive been trying to get my girlfriend into classical music but she just isnt interested.','Im Baching up the wrong tree..','2018-08-29',12,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What’s Whitney Houston’s favorite type of coordination?','HAAAAANNNNNNDDDDD EEEEEYYYYYEEEE.','2018-11-07',3,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What does a clock do when it’s hungry???','It goes back four seconds.','2018-12-04',2,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What is better than a terabyte?','An Antero-byte.','2018-05-01',1,0,3);

--31 to 40
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Math?','I cant seem to understand factorials.','2018-03-26',12,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Physics?','I cant seem to understand electricity.','2018-05-21',13,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Science?','I cant seem to understand cells.','2018-11-16',11,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with English?','I cant seem to understand grammar.','2018-01-24',9,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with French?','I cant seem to understand verbs.','2018-12-01',7,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Human Anatomy?','I cant seem to understand the arm.','2018-02-22',5,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Dog Anatomy?','I cant seem to understand it properly.','2018-04-24',6,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with C++?','I cant seem to understand C++ vectors.','2018-01-29',11,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with Python?','I cant seem to understand everything.','2018-11-21',9,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Can anyone help me with C?','I cant seem to understand null terminators.','2018-03-11',8,0,4);

--41 to 50
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Our idea of God tells us more about ourselves','-Charles King.','2018-12-01',4,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I can accept failure, everyone fails at something. But I cant accept not trying.','-Michael Jordan.','2018-12-07',5,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Don’t talk, act. Don’t say, show. Don’t promise, prove.','-Unknown.','2018-12-08',6,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Hit or Miss. I guess they never miss, huh.','-Antero.','2018-12-09',17,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Impossible is for the unwilling.','-John Keates.','2018-12-10',6,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('A goal without a plan is just a wish','-Antoine de Saint Exupéry.','2018-12-11',8,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('LTW is love, LTW is life','-MIEIC.','2018-12-12',10,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Beatiful','You are beautiful, no matter what they say.','2018-07-10',7,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Think not, its going to be fine',"-Tracer",'2018-10-03',8,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I fear one day I will meet God, he Will sneeze and I wont know what to say.','-Ronnie Shakes','2018-12-01',9,0,5);

--51 to 60
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('FC Porto is the best club in Europe right now','Bi incoming.','2018-09-19',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Marega is the best player in the world','Maregod.','2018-09-29',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Brahimi is an absolute magician','BRAHIMI. BRAHIMI.','2018-10-09',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Corona is very good. And Im not talking about the beer.','JESUS. CORONA.','2018-10-19',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Soares is FC Porto next matador','TIQUINHO. SOARES.','2018-10-29',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Eder Militao is really something else.','Best defender in Europe right now.','2018-11-09',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Danilo is a better wall than Trumps wall','Maregod.','2018-11-19',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('FC Porto >>> Benfica','Ez.','2018-11-29',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('FC Porto >>> All','True that.','2018-12-09',1,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('KOBE!','Dunked.','2018-12-16',2,0,6);

--61 to 70
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins LoL World Cup','Congratulations EU!','2018-02-16',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Overwatch World Cup','Congratulations EU!','2018-03-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Counter Strike World Cup','Congratulations EU!','2018-04-20',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Dota2 World Cup','Congratulations EU!','2018-05-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Rocket League World Cup','Congratulations EU!','2018-06-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Call of Duty World Cup','Congratulations EU!','2018-07-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins WoW World Cup','Congratulations EU!','2018-08-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins PUBG World Cup','Congratulations EU!','2018-09-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Tetris World Cup','Congratulations EU!','2018-11-26',15,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Fnatic wins Fortnite World Cup','Congratulations EU!','2018-12-08',15,0,7);

--71 to 80
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_riding','Image.','2018-04-23',17,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_cat','Image.','2018-04-24',16,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_dog','Image.','2018-04-25',15,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_hospital','Image.','2018-04-26',14,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_spirit','Image.','2018-04-27',17,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_guest','Image.','2018-04-28',12,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_think','Image.','2018-04-29',17,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_criminal','Image.','2018-04-30',9,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_xmas','Image.','2018-05-29',10,0,8);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('cursed_everything','Image.','2018-09-29',5,0,8);

--81 to 85
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Grandpa: What has 4 legs, but isnt alive?','Boy: A chair, haha, nice try gran- Grandpa - its your dog. Hes dead Jimmy.','2018-05-11',1,0,9);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('The recipe said, “Set the oven to 180 degrees.”','Now I cant open it, as the door faces the wall.','2018-05-05',1,0,9);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Tik tok','It hurts my kidney.','2018-04-26',13,0,9);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I love youtube rewind','Dont judge me.','2018-05-26',14,0,9);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Yes.','no.','2018-08-21',10,0,9);

--86 to 94
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by watering my christmas tree','By watering it too much, it fell over the vase and damaged my wooden floor. RIP.','2018-05-26',16,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by playing 32 hours of Tetris','I got too tired and collapsed. Im now in the hospital.','2017-05-26',11,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by erasing my school projects from the hard drive','Now my semester is ruined, RIP.','2018-01-21',16,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by bringing coffee near the computer','Spilled it over the computer and now I cant work.','2018-01-29',13,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by celebrating christmas','Drank too much champagne and ruined a family dinner','2018-05-26',8,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by getting drunk in my nephews birthday party','Collapsed in the middle of the party and now my nephew hates me.','2018-05-06',9,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by not studying PLOG','Now I need to go do the test again.','2018-06-02',12,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by drinking too much water before a test','Suffered through the entire test and couldnt concentrate.','2018-06-18',4,0,10);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('TIFU by watering my cactus','By watering it too much, it died. RIP.','2018-08-22',16,0,10);


INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Tell him you stole $4,999. Thats a different class of felony.','2018-12-16',1);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Wow. Good luck cleaning that up.','2018-12-16',1);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Wow. That sucks.','2018-12-16',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Haha. Thank you','2018-12-16',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Very Inspirational','2018-12-16',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('I thought so','2018-12-16',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Very good!','2018-12-16',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Poor tree.','2018-12-16',3);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Feels Bad.','2018-12-16',4);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Someone hire this man','2018-12-16',5);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Comment 101010','2018-12-16',10);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Maybe she just cant Handel it.','2018-12-16',1);


INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (60,5);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (60,6);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (60,7);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (60,1);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (60,2);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (11,3);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (21,8);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (21,9);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (21,10);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (27,12);


INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (1,2);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (2,3);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (4,5);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (5,6);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (7,8);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (8,9);

INSERT INTO SUBSCRIBER (userId, channelId) VALUES (1,1);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,1);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (1,2);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,2);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (1,3);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,3);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (16,4);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,5);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (9,1);

INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,1);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,6);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (5,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (12,1);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (13,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (14,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (15,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (16,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (17,1);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (52,6);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (61,5);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (33,3);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (8,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (19,1);

INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (1,14);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (5,4);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (3,2);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (4,2);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (7,14);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (66,4);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (23,2);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (72,2);

INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (2,11);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (4,8);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (3,2);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (5,11);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (3,8);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (9,2);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (6,2);

INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (2,2);
INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (4,2);
INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (2,1);
