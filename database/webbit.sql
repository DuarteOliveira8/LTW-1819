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


INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Pedro','Pedro','Gonçalves','pedro@gmail.com', '2702cb34ee041711b9df0c67a8d5c9de02110c80e3fc966ba8341456dbc9ef2b', 'Sim.', '3.jpg','1998-10-16');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('DuarteOliveira8','Duarte','Oliveira','duarte@gmail.com', 'd5b64690663f2177ef0da201b741b84cd4659fdcb7fa2e2440c4f1e4ee8b2aba', 'Sim.', '3.jpg','1998-10-16');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('MariaNeves19','Maria','Neves','Maneves@gmail.com', '65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5', 'hello 1', '3.jpg','1998-08-15');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('SilvaJoao','Joao','Silva','JS1982@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'hello 2', '2.jpg','1994-03-15');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Peixoto98','Leonor','Peixoto','LPEMAIL@hotmail.com', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', 'hello 3', '2.jpg','1999-09-25');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('MatildeSantos','Matilde','Santos','matildesantos@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'hello 4', '1.jpg','1998-01-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Francisco35','Francisco','Silva','fs9999@gmail.com', 'f4df5fb2a700c78a749de2d8749da8049aa2fbc831b0c8f4b790aacc2277e77d', 'hello 5', '4.jpg','1998-10-08');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('AfonsoSantos99','Afonso','Santos','afonsoS@hotmail.com', '7a6cff37883086eacdae5540af9f90971c5c4bd1d43fd65ca8c3101926f38f74', 'hello 6', '3.jpg','2000-12-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('CarolFerr','Carolina','Ferreira','carolFerreira@hotmail.com', 'b2e9a0574b5466acb3c5b909ee216578a8f97782ea4227679123ce41c1b3c676', 'hello 7', '1.jpg','1989-11-23');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('VascoOliveira','Vasco','Oliveira','vascooo@gmail.com', '1a5376ad727d65213a79f3108541cf95012969a0d3064f108b5dd6e7f8c19b89', 'hello 8', '4.jpg','1998-08-23');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('FranciscoFilipe','Francisco','Filipe','Canelas@gmail.com', 'bf1474f5cdab99f709259e2c800bdba9cdb2ff0fbbed42ede3a4dfd5fd6232c2', 'hello 9', '3.jpg','1999-08-05');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Maregol','Moussa','Marega','Marega@hotmail.com', 'e094461145afaf76c97e96a7d9542c0b4f9eed158da7338c29a8400fa6d4ab3d', 'hello 10', '2.jpg','1989-09-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('CrisFCP12','Cristina','Ferreira','cristi@hotmail.com', 'aca3af4252fe6f0d2413b2209af5212eef17162c227d5563a86fc9fd7e82cffa', 'hello 11', '2.jpg','2005-12-31');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Matilde12','Matilde','Santos','matildesantos12@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'hello 12', '1.jpg','2012-12-12');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('BrunoRekicho','Bruno','Sousa','Rekicho@gmail.com', 'e7a94865bf232c9b3ee56bca7bf2ad76faa5887cb9e5a4b176446da4a27c1420', 'hello 13', '4.jpg','1999-02-18');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('DiogoLuisXX','Diogo','Lu�s','XXLuisXX@hotmail.com', '4dcab0d82ccb503fea0f6f7a4d63440981cf2755d9fba55733489e8c8091fdf5', 'hello 14', '3.jpg','1997-08-30');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('KatarinaMendes','Catarina','Mendes','KataMendes@hotmail.com', '5ccc2e8715d7a17c3110afe37b8561b84b450db8efcf187d90649f212201050f', 'hello 15', '1.jpg','1996-10-08');
INSERT INTO USER (username, firstName, lastName, email, password, bio, avatar, birthDate) VALUES ('Championships','Meek','Mill','MeekMilly@gmail.com', '932f3c1b56257ce8539ac269d7aab42550dacf8818d075f0bdf1990562aae3ef', 'hello 16', '4.jpg','1987-03-12');

INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Advice','This is a place where you can ask for advice on any subject',1);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Music','Insert your favourite musics in this place so we can discuss it.',2);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Funny','Welcome to Funny: Webbits largest humour depository',1);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('School','Insert your doubts about school subjects.',10);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Quotes','For your favorite quotes. Current quotes, historic quotes, movie quotes, song lyric quotes,...',2);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Sports','Watch out for news about your favourite sports',1);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('E-Sports','News about the best e-sport scenes',2);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Cursed images','Cursed slogan',2);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('Dank memes','very dankerino',2);
INSERT INTO CHANNEL (name, slogan, idCreator) VALUES ('TIFU',"Today I F'd up",2);

INSERT INTO RULE (description, idChannel) VALUES ('Be Nice.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('Posts must ask for advice.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('No spam.', 1);
INSERT INTO RULE (description, idChannel) VALUES ('No leaks or piracy.', 2);
INSERT INTO RULE (description, idChannel) VALUES ('No Dark Jokes.', 2);
INSERT INTO RULE (description, idChannel) VALUES ('Be Nice.', 4);
INSERT INTO RULE (description, idChannel) VALUES ('No repost.', 5);

INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Ola pedro','Diz ola de volta.','2018-09-20',2,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Im about to tell my boss I stole almost $5000','No one even has a clue the money is missing but I just cant hide it anymore.... I just posted this to vent and maybe help with my anxiety','2018-11-30',2,0,1);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Our idea of God tells us more about ourselves','yes.','2018-12-01',2,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('What are schools called that i can attend in holidays.','I live in Melbourne and am seriously falling behind in work. I was wondering what are the schools called that I can attend in the holidays so I can catch up on work.','2018-11-20',6,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('You Are Living Proof That God Has A Sense Of Humor','hello.','2018-11-05',14,0,3);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Beatiful','You are beautiful.','2018-07-10',13,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Think not',"It's going to be fine.",'2018-10-03',14,0,6);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Ola duarte','Ja disse.','2018-09-19',1,0,2);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I fear one day I will meet God, he Will sneeze and I wont know what to say. - Ronnie Shakes','no.','2018-12-01',12,0,5);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('Yes.','no.','2018-08-21',12,0,4);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('I think you ar cool','NOT.','2018-06-07',7,0,7);
INSERT INTO STORY (title, description, storyDate, idAuthor, upvoteRatio, channel) VALUES ('How about dat','Cash me oustide.','2018-05-26',2,0,1);

INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Tell him you stole $4,999. Thats a different class of felony.','2018-11-30',1);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Someone hire this man','2018-12-01',5);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Comment 101010','2018-12-01',10);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Haha. Thank you','2018-12-01',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Very Inspirational','2018-12-01',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('I thought so','2018-11-02',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Very good!','2018-12-13',2);
INSERT INTO COMMENT (description, commentDate, idAuthor) VALUES ('Feels Bad.','2018-12-06',4);

INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (2,1);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (1,2);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (1,3);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (3,4);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (4,5);
INSERT INTO STORYCOMMENT (storyId, commentId) VALUES (5,8);

INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (1,6);
INSERT INTO CHAINCOMMENT (parentComment, childComment) VALUES (3,7);

INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,1);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (1,1);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (16,4);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (2,5);
INSERT INTO SUBSCRIBER (userId, channelId) VALUES (9,1);

INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,1);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,6);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (1,2);
INSERT INTO STORYUPVOTE (storyId, userId) VALUES (5,2);

INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (1,14);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (5,4);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (3,2);
INSERT INTO STORYDOWNVOTE (storyId, userId) VALUES (4,2);

INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (2,11);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (4,8);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (3,2);
INSERT INTO COMMENTUPVOTE (commentId, userId) VALUES (1,2);

INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (2,2);
INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (4,2);
INSERT INTO COMMENTDOWNVOTE (commentId, userId) VALUES (2,1);
