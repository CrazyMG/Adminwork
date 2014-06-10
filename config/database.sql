/**
* Creation of the database schema.
*/
/**
 * Create Client table
 */

create table if not exists Client(
	clientId integer primary key auto_increment,
	organization varchar(50) not null,
	description varchar(255),
	website varchar(150)
);

/**
* Create User table
*/
create table if not exists User(
	userId integer primary key auto_increment,
	name varchar(50) not null,
	surname varchar(50) not null,
	email varchar(50) not null,
	password varchar(100) not null, /* MD5 encripted*/
	role varchar(50) not null,
	isActive boolean not null,
	avgRate double,
	thumbnail BLOB
);

/**
 * Create Message table
 */
create table if not exists Message(
	messageId integer primary key auto_increment,
	senderId integer not null,
	receiverId integer not null,
	content text not null,
	dateSend datetime not null, 
	FOREIGN KEY (senderId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (receiverId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION
);
		
/**
 * Create Absence table
 */
create table if not exists Absence(
	absenceId integer primary key auto_increment,
	reason varchar(50) not null,
	note varchar(200),
	userId integer not null,
	FOREIGN KEY (userId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION
);

/**
 * Create Contact table
 */		
create table if not exists Contact(
	contactId integer primary key auto_increment,
	referent varchar(50) not null,
	telephone varchar(50),
	fax varchar(50),
	city varchar(50),
	province varchar(50),
	region varchar(50),
	state varchar(50),
	country varchar(50),
	address varchar(255),
	clientId integer,
	userId integer,
	FOREIGN KEY (clientId) REFERENCES Client(clientId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (userId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION
);

/**
 * Create Project table
 */
create table if not exists Project(
	projectId integer primary key auto_increment,
	title varchar(100) not null,
	description text,
	startDate date not null,
	endDate date,
	status varchar(50) not null,
	url varchar(255),
	note varchar(255),
	clientId integer not null,
	FOREIGN KEY (clientId) REFERENCES Client(clientId)
		ON DELETE NO ACTION /* 'No action' is a choice made to preserve data, you can think to set it 'CASCADE' */
		ON UPDATE NO ACTION
);

/**
 * Create Task table
 */
create table if not exists Task(
	taskId integer primary key auto_increment,
	title varchar(50) not null,
	status varchar(30) not null,
	projectId integer not null,
	FOREIGN KEY (projectId) REFERENCES Project(projectId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
);
		
/**
 * Create Activity table 
 */
create table if not exists Activity(
	activityId integer primary key auto_increment,
	startTime datetime not null,
	endTime datetime not null,
	log_text varchar(200),
	userId integer not null,
	taskId integer not null,
	FOREIGN KEY (userId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (taskId) REFERENCES Task(taskId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
);

/**
 * Create Assignment table
 */
create table if not exists Assignment(
	assignmentId integer primary key auto_increment,
	userId integer not null,
	projectId integer not null,
	rate double not null,
	isLeader boolean not null default false,
	FOREIGN KEY (userId) REFERENCES User(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (projectId) REFERENCES Project(projectId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
)

