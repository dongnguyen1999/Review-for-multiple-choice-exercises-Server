/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     1/12/2021 8:20:50 AM                         */
/*==============================================================*/

drop table if exists FACULTY;

drop table if exists MAJOR;

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
   examId               bigint not null AUTO_INCREMENT,
   userId               int not null,
   subjectId            int not null,
   createDate               timestamp not null,
   closeDate                timestamp not null,
   duration                 int not null,
   nbQuestion               int not null,
   score                    float,
   primary key (examId)
);

/*==============================================================*/
/* Table: QUESTION                                              */
/*==============================================================*/
create table QUESTION
(
   questionId           bigint not null AUTO_INCREMENT,
   subjectId            int not null,
   questionName         varchar(500) not null,
   answer1             varchar(500) not null,
   answer2              varchar(500) not null,
   answer3              varchar(500) not null,
   answer4              varchar(500) not null,
   answer               int not null,
   primary key (questionId)
);

/*==============================================================*/
/* Table: FACULTY                                             */
/*==============================================================*/
create table FACULTY
(
   facultyId           int not null AUTO_INCREMENT,
   facultyName         varchar(256) not null,
   primary key (facultyId)
);


/*==============================================================*/
/* Table: MAJOR                                             */
/*==============================================================*/
create table MAJOR
(
   majorId           int not null AUTO_INCREMENT,
   facultyId         int not null,
   majorName         varchar(256) not null,
   primary key (majorId)
);

/*==============================================================*/
/* Table: SUBJECT                                             */
/*==============================================================*/
create table SUBJECT
(
   subjectId           int not null AUTO_INCREMENT,
   majorId             int not null,
   subjectName         varchar(50) not null,
   primary key (subjectId)
);

/*==============================================================*/
/* Table: TASK                                                  */
/*==============================================================*/
create table TASK
(
   examId               bigint not null AUTO_INCREMENT,
   questionId           bigint not null,
   answerTask           int,
   primary key (examId, questionId)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   userId               int not null AUTO_INCREMENT,
   email                varchar(100) not null,
   password             varchar(100) not null,
   name                 varchar(100),
   phone                varchar(15),
   avatar               varchar(256),
   primary key (userId),
   unique (email)
);

alter table EXAM add constraint FK_USER_CO_EXAM foreign key (userId)
      references USER (userId) on delete restrict on update restrict;

alter table EXAM add constraint FK_EXAM_THUOC_SUBJECT foreign key (subjectId)
      references SUBJECT (subjectId) on delete restrict on update restrict;

alter table QUESTION add constraint FK_QUESTION_THUOC_SUBJECT foreign key (subjectId)
      references SUBJECT (subjectId) on delete restrict on update restrict;

alter table SUBJECT add constraint FK_SUBJECT_THUOC_MAJOR foreign key (majorId)
      references MAJOR (majorId) on delete restrict on update restrict;

alter table MAJOR add constraint FK_MAJOR_THUOC_FACULTY foreign key (facultyId)
      references FACULTY (facultyId) on delete restrict on update restrict;

alter table TASK add constraint FK_EXAM_TASK foreign key (examId)
      references EXAM (examId) on delete restrict on update restrict;

alter table TASK add constraint FK_TASK_QUESTION foreign key (questionId)
      references QUESTION (questionId) on delete restrict on update restrict;

