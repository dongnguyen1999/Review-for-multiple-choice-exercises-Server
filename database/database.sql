/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     1/12/2021 8:20:50 AM                         */
/*==============================================================*/


drop table if exists EXAM;

drop table if exists QUESTION;

drop table if exists SUBJECT;

drop table if exists TASK;

drop table if exists USER;

/*==============================================================*/
/* Table: EXAM                                                  */
/*==============================================================*/
create table EXAM
(
   EXAMID               bigint not null AUTO_INCREMENT,
   USERID               int not null,
   CREATEDATE               timestamp not null,
   DURATION                 int,
   primary key (EXAMID)
);

/*==============================================================*/
/* Table: QUESTION                                              */
/*==============================================================*/
create table QUESTION
(
   QUESTIONID           bigint not null AUTO_INCREMENT,
   SUBJECTID            int not null,
   QUESTIONNAME         varchar(500) not null,
   ANSWER1             varchar(500) not null,
   ANSWER2              varchar(500) not null,
   ANSWER3              varchar(500) not null,
   ANSWER4              varchar(500) not null,
   ANSWER               int not null,
   primary key (QUESTIONID)
);

/*==============================================================*/
/* Table: SUBJECT                                             */
/*==============================================================*/
create table SUBJECT
(
   SUBJECTID           int not null AUTO_INCREMENT,
   SUBJECTNAME         varchar(50) not null,
   primary key (SUBJECTID)
);

/*==============================================================*/
/* Table: TASK                                                  */
/*==============================================================*/
create table TASK
(
   EXAMID               bigint not null AUTO_INCREMENT,
   QUESTIONID           bigint not null,
   ANSWERTASK           int,
   primary key (EXAMID, QUESTIONID)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   USERID               int not null AUTO_INCREMENT,
   NAME                 varchar(100),
   USERNAME             varchar(100) not null,
   PASSWORD             varchar(100) not null,
   EMAIL                varchar(100),
   PHONE                numeric(8,0),
   AVATAR               varchar(256),
   primary key (USERID)
);

alter table EXAM add constraint FK_USER_CO_EXAM foreign key (USERID)
      references USER (USERID) on delete restrict on update restrict;

alter table QUESTION add constraint FK_QUESTION_THUOC_SUBJECT foreign key (SUBJECTID)
      references SUBJECT (SUBJECTID) on delete restrict on update restrict;

alter table TASK add constraint FK_EXAM_TASK foreign key (EXAMID)
      references EXAM (EXAMID) on delete restrict on update restrict;

alter table TASK add constraint FK_TASK_QUESTION foreign key (QUESTIONID)
      references QUESTION (QUESTIONID) on delete restrict on update restrict;

