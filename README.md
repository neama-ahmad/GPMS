## GPMS (Graduation Project Management System)

### Problem Definition

The Projects Committee Department of Computer Science at Taiba University face a lot of problems during project registration and coordination process for students and supervisor 
and difficulty of managing many groups at same time and receiving reports from organizing discussions, the processes are done manually and take a lot of time and effort.
And student face a problems when they the formation of graduation project groups may take a lot of effort and time and this process lasts from a week to 3 weeks to form 
groups and connect them with a supervisor. There is also a problem in the process of choosing a project idea commensurate with the capabilities of all the members of the group 
since it is possible to connect the members of the group to each other without specifying their compatible ability to work on the idea of a suitable graduation project 
and the field of specialization of the selected supervisor. One of the problems that the student also faces is the process of reviewing 
previous projects, which takes a lot of time from the student to read the library copies. The following identifies several problems that the student 
and the project committee may face. One of the challenges that supervisors and the Graduation Projects Committee face in managing 
graduation projects in the Computer Science department is the difficulty of monitoring and tracking the progress of numerous project groups 
and effectively guiding students toward their academic goals. The committee also struggles to maintain effective communication with students. 
These challenges complicate the supervision process of graduation projects and may lead to delays in project delivery or the submission of unsuitable projects. 
Additionally, supervisors may need to regularly communicate with committee members to provide reports and updates on the projects, and this can be challenging 
if they don't have an efficient means of communication. The Graduation Project Management System aims to address these 
challenges and provide a comprehensive solution for more efficient management of graduation projects. Therefore, it can play a significant role 
in improving the experience of both the committee and students in managing and successfully completing projects.

--------------------------------------------------------------------------------------------------------------------------------------------------------

### Project Scope 
The project is aimed at the Project Committee's graduation at the Computer Sciences Department. It enables the Projects Committee to easily manage and organize student graduation projects. The project will be implemented through web applications, activate many project features, and provide flexibility to serve students, supervisors and examiners as well.

-----------------------------------------------------------------------------------------------------------------------------------------------------------------

### Requirements Elicitation
#### Functional Requirements
##### The system should provide GPCommittee (Graduation Project committee) with following functions:
1) They should log in using their email and password.
2)They can create users' accounts and grant them permissions. 
3) They can activate students' accounts. 
4) They can organize final discussions and link the examiners to the groups.
5) They can send notifications to the students and the supervisors.
6) They can archive projects.
7) They can upload and download files.
8) They can manage groups.
9)They can redirect files to examiners.
##### The system should provide the students with following functions:
1)	They should sign up in the system.
2)	They should log in using their email and password after activated their accounts by GPCommittee.
3)	They can create a new group and add members.
4)	The students in the same group can chat with each other and with the supervisor as well.
5)	They can search for a group and send a request to join a group.
6)	They can search for a supervisor and send an offer to the selected supervisor.
7)	They can upload and download files.
8)	They can show all archived projects.
9)	They can show final discussion details which organized by GPCommittee.
##### The system should provide the supervisors with following functions:
1)	They should log in using their email and password provided by GPCommittee.
2)	They can suggest topics that they are interested in.
3)	They can approve offers submitted by students.
4)	They chat within that group.
5)	They can show final discussion details which organized by GPCommittee.
6)	They can submit the student's grades.
7)	They can upload and download files.
8)	They can show all archived projects.
##### The system should provide the examiners with following functions:
1)	They should log in using their email and password provided by GpCommittee.
2)	They can show final discussion details which organized by GPCommittee.
3)	They can submit the student's grades.
4)	They can upload and download files.

#### Non-Functional Requirements
###### Performance
1)	Uploading and downloading files should be extremely fast.
2)	The system responds promptly when the user interacts with it.
###### Availability
1)	The system is available 24 hours a day, 7 days a week.
Usability
1)	User interface (UI) is easy to use and easy to navigate.
2)	User interface (UI) is compatible with all devices.
###### Privacy
1)	The system protects the user's personal information.
2)	The system keeps chatting inside groups private.
###### Reliability
1)	The system is certified and completely belongs to Taibah university. 
###### Accuracy
1)	The projects are reviewed by the GPCommittee before publishing.
2)	Organizing discussions and scheduling appointments is precise.
###### Security
1)	The users log in by academic email owned to Taibah university and strong password.
2)	The user's accounts are created by the administrator (GPCommittee).
