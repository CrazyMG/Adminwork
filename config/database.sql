/**
* Creation of the database schema.
*/
/**
 * Create Client table
 */

create table if not exists clients(
	clientId integer primary key auto_increment,
	organization varchar(50) not null,
	description varchar(255),
	website varchar(150)
);

/**
* Create User table
*/
create table if not exists users(
	userId integer primary key auto_increment,
	name varchar(50) not null,
	surname varchar(50) not null,
	email varchar(50) not null UNIQUE,
	password varchar(100) not null, /* MD5 encripted*/
	role varchar(50) not null,
	isActive boolean not null,
	avgRate double,
	thumbnail varchar(150)
);

/**
 * Create Message table
 */
create table if not exists posts(
	postId integer primary key auto_increment,
	senderId integer not null,
	receiverId integer not null,
	content text not null,
	dateSend datetime not null, 
	FOREIGN KEY (senderId) REFERENCES users(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (receiverId) REFERENCES users(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION
);
		
/**
 * Create Absences table /////////////////////////////////////////////////////////////////////////////////
 */

/**
 * Create Contact table
 */		
create table if not exists contacts(
	contactId integer primary key auto_increment,
	referent varchar(50) not null,
	email varchar(50),
	phone varchar(50),
	fax varchar(50),
	address varchar(100),
	latitude varchar(30),
	longitude varchar(30),
	isMain boolean,
	clientId integer,
	userId integer,
	FOREIGN KEY (clientId) REFERENCES clients(clientId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (userId) REFERENCES users(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION
);

/**
 * Create Project table
 */
create table if not exists projects(
	projectId integer primary key auto_increment,
	title varchar(100) not null,
	description text,
	startDate date not null,
	endDate date,
	status varchar(50) not null,
	url varchar(255),
	note varchar(255),
	clientId integer not null,
	FOREIGN KEY (clientId) REFERENCES clients(clientId)
		ON DELETE NO ACTION /* 'No action' is a choice made to preserve data, you can think to set it 'CASCADE' */
		ON UPDATE NO ACTION
);

/**
 * Create Task table
 */
create table if not exists tasks(
	taskId integer primary key auto_increment,
	title varchar(50) not null,
	status varchar(30) not null,
	projectId integer not null,
	FOREIGN KEY (projectId) REFERENCES projects(projectId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
);
		
/**
 * Create Activity table 
 */
create table if not exists activities(
	activityId integer primary key auto_increment,
	startTime datetime not null,
	endTime datetime not null,
	log_text varchar(200),
	userId integer not null,
	taskId integer not null,
	FOREIGN KEY (userId) REFERENCES users(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (taskId) REFERENCES tasks(taskId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
);

/**
 * Create Assignment table
 */
create table if not exists assignments(
	assignmentId integer primary key auto_increment,
	userId integer not null,
	projectId integer not null,
	rate double not null,
	isLeader boolean not null default false,
	FOREIGN KEY (userId) REFERENCES users(userId)
		ON DELETE NO ACTION 
		ON UPDATE NO ACTION,
	FOREIGN KEY (projectId) REFERENCES projects(projectId)
		ON DELETE CASCADE 
		ON UPDATE NO ACTION
)

