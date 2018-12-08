.bail ON
.mode columns
.headers on
.nullvalue NULL

PRAGMA FOREIGN_KEYS=ON;

DROP TABLE IF EXISTS RULES;
DROP TABLE IF EXISTS CHANNEL;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS STORY;
DROP TABLE IF EXISTS COMMENT;
DROP TABLE IF EXISTS SUBSCRIBER;
DROP TABLE IF EXISTS UPVOTE;
DROP TABLE IF EXISTS DOWNVOTE;


CREATE TABLE RULES(
	ID		 INTEGER PRIMARY KEY AUTOINCREMENT,
	Title		 STRING NOT NULL,
	Description	 STRING NOT NULL,
	idChannel	 INTEGER REFERENCES CHANNEL(ID) ON DELETE CASCADE NOT NULL
);


CREATE TABLE CHANNEL(
	ID		 INTEGER PRIMARY KEY AUTOINCREMENT,
	Name		 STRING NOT NULL,
	Description	 STRING NOT NULL,
	idCreator	 INTEGER REFERENCES USER(ID) ON DELETE CASCADE NOT NULL
);


CREATE TABLE USER(
	ID		 		 INTEGER PRIMARY KEY AUTOINCREMENT,
	Username	 STRING NOT NULL UNIQUE,
	FirstName	 STRING NOT NULL,
	LastName	 STRING NOT NULL,
	Email		   STRING NOT NULL UNIQUE,
	Password	 CHAR (256) NOT NULL,
	Bio		     STRING DEFAULT "",
	Avatar		 STRING DEFAULT "default-profile.png",
	BirthDate	 DATE NOT NULL
);

CREATE TABLE STORY(
	ID		 INTEGER PRIMARY KEY AUTOINCREMENT,
	Title		 STRING NOT NULL,
	Text		 STRING,
	StoryDate	 DATE NOT NULL,
	idAuthor	 INTEGER REFERENCES USER(ID) ON DELETE CASCADE NOT NULL,
	UpvoteRatio	 INTEGER,
	ChannelStory	 INTEGER REFERENCES CHANNEL(ID) ON DELETE CASCADE NOT NULL
);

CREATE TABLE COMMENT(
	ID		 INTEGER PRIMARY KEY AUTOINCREMENT,
	Text		 STRING NOT NULL,
	CommentDate	 DATE NOT NULL,
	idStory		 INTEGER REFERENCES STORY(ID) ON DELETE CASCADE NOT NULL,
	idAuthor	 INTEGER REFERENCES USER(ID) ON DELETE CASCADE NOT NULL,
	idComment	 INTEGER REFERENCES COMMENT(ID) ON DELETE CASCADE
);

CREATE TABLE SUBSCRIBER(
	UserID    	 INTEGER REFERENCES USER(ID) ON DELETE CASCADE,
    ChannelID 	 INTEGER REFERENCES CHANNEL(ID) ON DELETE CASCADE,
    PRIMARY KEY (
    	UserID,
    	ChannelID
    )
);

CREATE TABLE UPVOTE(
	StoryID    	 INTEGER REFERENCES STORY(ID) ON DELETE CASCADE,
    UserID		 INTEGER REFERENCES USER(ID) ON DELETE CASCADE,
    PRIMARY KEY (
    	StoryID,
    	UserID
    )
);

CREATE TABLE DOWNVOTE(
	StoryID    	 INTEGER REFERENCES STORY(ID) ON DELETE CASCADE,
    UserID		 INTEGER REFERENCES USER(ID) ON DELETE CASCADE,
    PRIMARY KEY (
        StoryID,
        UserID
    )
);



DROP TRIGGER IF EXISTS CheckBeforeUpvote;
DROP TRIGGER IF EXISTS CheckBeforeDownvote;
DROP TRIGGER IF EXISTS AddUpvote;
DROP TRIGGER IF EXISTS AddDownvote;
DROP TRIGGER IF EXISTS RemoveUpvote;
DROP TRIGGER IF EXISTS RemoveDownvote;


CREATE TRIGGER CheckBeforeUpvote
BEFORE INSERT ON UPVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM DOWNVOTE WHERE (DOWNVOTE.StoryID=NEW.StoryID and DOWNVOTE.UserID=NEW.UserID))
BEGIN
	SELECT RAISE(rollback, "You cant upvote and downvote the same post");
END;


CREATE TRIGGER CheckBeforeDownvote
BEFORE INSERT ON DOWNVOTE
FOR EACH ROW
WHEN EXISTS (SELECT * FROM UPVOTE WHERE (UPVOTE.StoryID=NEW.StoryID and UPVOTE.UserID=NEW.UserID))
BEGIN
	SELECT RAISE(rollback, "You cant upvote and downvote the same post");
END;


CREATE TRIGGER AddUpvote
AFTER INSERT ON UPVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET UpvoteRatio = UpvoteRatio + 1 WHERE (Story.ID = NEW.StoryID);
END;

CREATE TRIGGER AddDownvote
AFTER INSERT ON DOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET UpvoteRatio = UpvoteRatio - 1 WHERE (Story.ID = NEW.StoryID);
END;

CREATE TRIGGER RemoveUpvote
AFTER DELETE ON UPVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET UpvoteRatio = UpvoteRatio - 1 WHERE (Story.ID = NEW.StoryID);
END;

CREATE TRIGGER RemoveDownvote
AFTER DELETE ON DOWNVOTE
FOR EACH ROW
BEGIN
	UPDATE STORY SET UpvoteRatio = UpvoteRatio + 1 WHERE (Story.ID = NEW.StoryID);
END;


INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('MariaNeves19','Maria','Neves','Maneves@gmail.com', '65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5', 'hello 1', '3.jpg','1998-08-15');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('SilvaJoao','Joao','Silva','JS1982@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'hello 2', '2.jpg','1994-03-15');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('Peixoto98','Leonor','Peixoto','LPEMAIL@hotmail.com', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', 'hello 3', '2.jpg','1999-09-25');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('MatildeSantos','Matilde','Santos','matildesantos@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'hello 4', '1.jpg','1998-01-12');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('Francisco35','Francisco','Silva','fs9999@gmail.com', 'f4df5fb2a700c78a749de2d8749da8049aa2fbc831b0c8f4b790aacc2277e77d', 'hello 5', '4.jpg','1998-10-08');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('AfonsoSantos99','Afonso','Santos','afonsoS@hotmail.com', '7a6cff37883086eacdae5540af9f90971c5c4bd1d43fd65ca8c3101926f38f74', 'hello 6', '3.jpg','2000-12-12');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('CarolFerr','Carolina','Ferreira','carolFerreira@hotmail.com', 'b2e9a0574b5466acb3c5b909ee216578a8f97782ea4227679123ce41c1b3c676', 'hello 7', '1.jpg','1989-11-23');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('VascoOliveira','Vasco','Oliveira','vascooo@gmail.com', '1a5376ad727d65213a79f3108541cf95012969a0d3064f108b5dd6e7f8c19b89', 'hello 8', '4.jpg','1998-08-23');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('FranciscoFilipe','Francisco','Filipe','Canelas@gmail.com', 'bf1474f5cdab99f709259e2c800bdba9cdb2ff0fbbed42ede3a4dfd5fd6232c2', 'hello 9', '3.jpg','1999-08-05');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('Maregol','Moussa','Marega','Marega@hotmail.com', 'e094461145afaf76c97e96a7d9542c0b4f9eed158da7338c29a8400fa6d4ab3d', 'hello 10', '2.jpg','1989-09-12');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('CrisFCP12','Cristina','Ferreira','cristi@hotmail.com', 'aca3af4252fe6f0d2413b2209af5212eef17162c227d5563a86fc9fd7e82cffa', 'hello 11', '2.jpg','2005-12-31');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('Matilde12','Matilde','Santos','matildesantos12@gmail.com', 'f8b0dd15ec7a0b0f29ce8be21997c56029be96e46007aeed25759fb21368c631', 'hello 12', '1.jpg','2012-12-12');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('BrunoRekicho','Bruno','Sousa','Rekicho@gmail.com', 'e7a94865bf232c9b3ee56bca7bf2ad76faa5887cb9e5a4b176446da4a27c1420', 'hello 13', '4.jpg','1999-02-18');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('DiogoLuisXX','Diogo','Lu�s','XXLuisXX@hotmail.com', '4dcab0d82ccb503fea0f6f7a4d63440981cf2755d9fba55733489e8c8091fdf5', 'hello 14', '3.jpg','1997-08-30');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('KatarinaMendes','Catarina','Mendes','KataMendes@hotmail.com', '5ccc2e8715d7a17c3110afe37b8561b84b450db8efcf187d90649f212201050f', 'hello 15', '1.jpg','1996-10-08');
INSERT INTO USER (Username, FirstName, LastName, Email, Password, Bio, Avatar, BirthDate) VALUES ('Championships','Meek','Mill','MeekMilly@gmail.com', '932f3c1b56257ce8539ac269d7aab42550dacf8818d075f0bdf1990562aae3ef', 'hello 16', '4.jpg','1987-03-12');


INSERT INTO CHANNEL (Name, Description, idCreator) VALUES ('Advice','This is a place where you can ask for advice on any subject',1);
INSERT INTO CHANNEL (Name, Description, idCreator) VALUES ('Music','Insert your favourite musics in this place so we can discuss it.',4);
INSERT INTO CHANNEL (Name, Description, idCreator) VALUES ('Funny','Welcome to Funny: Webbits largest humour depository',1);
INSERT INTO CHANNEL (Name, Description, idCreator) VALUES ('School','Insert your doubts about school subjects.',10);
INSERT INTO CHANNEL (Name, Description, idCreator) VALUES ('Quotes','For your favorite quotes. Current quotes, historic quotes, movie quotes, song lyric quotes,...',12);


INSERT INTO RULES (Title,Description,idChannel) VALUES ('1-Be Nice.','We do not tolerate trolling, harassment, threats, hate-speech, discrimination, triggering, rudeness, or other uncivil actions.',1);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('2-Posts must ask for advice.','No posts offering general unsolicited advice.',1);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('3-No spam.','No posts that dont belong in this channel.',1);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('1-No leaks or piracy.','No links to unauthorized music leaks or promotion of piracy.',2);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('1-No Dark Jokes.','We do not tolerate harassment, threats, hate-speech, discrimination, triggering, rudeness, or other uncivil jokes.',3);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('1-Be Nice.','We do not tolerate trolling, harassment, threats, hate-speech, discrimination, triggering, rudeness, or other uncivil actions.',4);
INSERT INTO RULES (Title,Description,idChannel) VALUES ('1-No repost.','Dont repost any post that was previously on this channel',5);


INSERT INTO STORY (Title,Text,StoryDate,idAuthor,UpvoteRatio,ChannelStory) VALUES ('Im about to tell my boss I stole almost $5000 from my company','No one even has a clue the money is missing but I just cant hide it anymore.... I just posted this to vent and maybe help with my anxiety','2018-11-30',2,0,1);
INSERT INTO STORY (Title,Text,StoryDate,idAuthor,UpvoteRatio,ChannelStory) VALUES ('Our idea of God tells us more about ourselves than about Him.-Thomas Merton',NULL,'2018-12-01',10,0,5);
INSERT INTO STORY (Title,Text,StoryDate,idAuthor,UpvoteRatio,ChannelStory) VALUES ('I fear one day I will meet God, he Will sneeze and I wont know what to say. - Ronnie Shakes',NULL,'2018-12-01',12,0,5);
INSERT INTO STORY (Title,Text,StoryDate,idAuthor,UpvoteRatio,ChannelStory) VALUES ('What are schools called that i can attend in holidays.','I live in Melbourne and am seriously falling behind in work. I was wondering what are the schools called that I can attend in the holidays so I can catch up on work.','2018-11-20',6,0,4);
INSERT INTO STORY (Title,Text,StoryDate,idAuthor,UpvoteRatio,ChannelStory) VALUES ('You Are Living Proof That God Has A Sense Of Humor',NULL,'2018-11-05',14,0,3);


INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Tell him you stole $4,999. Thats a different class of felony.','2018-11-30',1,1,NULL);
INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Someone hire this man','2018-12-01',1,5,1);
INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Haha. Thank you','2018-12-01',1,1,2);
INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Comment 101010','2018-12-01',1,10,2);
INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Very Inspirational','2018-12-01',3,16,NULL);
INSERT INTO COMMENT(Text,CommentDate,idStory,idAuthor,idComment) VALUES ('Feels Bad.','2018-12-06',5,4,NULL);


INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (2,1);
INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (1,1);
INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (5,1);
INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (16,4);
INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (12,5);
INSERT INTO SUBSCRIBER(UserID,ChannelID) VALUES (9,1);


INSERT INTO UPVOTE(StoryID,UserID) VALUES (1,1);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (1,6);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (1,12);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (5,1);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (3,11);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (4,8);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (4,9);
INSERT INTO UPVOTE(StoryID,UserID) VALUES (2,3);
INSERT INTO DOWNVOTE(StoryID,UserID) VALUES (1,14);
INSERT INTO DOWNVOTE(StoryID,UserID) VALUES (5,4);
INSERT INTO DOWNVOTE(StoryID,UserID) VALUES (5,11);
