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

### Requirements Elicitation
#### Functional Requirements
The system should provide GPCommittee (Graduation Project committee) with following functions:
•	They should log in using their email and password.
•	They can create users' accounts and grant them permissions. 
•	They can activate students' accounts. 
•	They can organize final discussions and link the examiners to the groups.
•	They can send notifications to the students and the supervisors.
•	They can archive projects.
•	They can upload and download files.
•	They can manage groups.
•	They can redirect files to examiners.
The system should provide the students with following functions:
•	They should sign up in the system.
•	They should log in using their email and password after activated their accounts by GPCommittee.
•	They can create a new group and add members.
•	The students in the same group can chat with each other and with the supervisor as well.
•	They can search for a group and send a request to join a group.
•	They can search for a supervisor and send an offer to the selected supervisor.
•	They can upload and download files.
•	They can show all archived projects.
•	They can show final discussion details which organized by GPCommittee.
The system should provide the supervisors with following functions:
•	They should log in using their email and password provided by GPCommittee.
•	They can suggest topics that they are interested in.
•	They can approve offers submitted by students.
•	They chat within that group.
•	They can show final discussion details which organized by GPCommittee.
•	They can submit the student's grades.
•	They can upload and download files.
•	They can show all archived projects.
The system should provide the examiners with following functions:
•	They should log in using their email and password provided by GpCommittee.
•	They can show final discussion details which organized by GPCommittee.
•	They can submit the student's grades.
•	They can upload and download files.

#### Non-Functional Requirements
Performance
•	Uploading and downloading files should be extremely fast.
•	The system responds promptly when the user interacts with it.
Availability
•	The system is available 24 hours a day, 7 days a week.
Usability
•	User interface (UI) is easy to use and easy to navigate.
•	User interface (UI) is compatible with all devices.
Privacy
•	The system protects the user's personal information.
•	The system keeps chatting inside groups private.
Reliability
•	The system is certified and completely belongs to Taibah university. 
Accuracy
•	The projects are reviewed by the GPCommittee before publishing.
•	Organizing discussions and scheduling appointments is precise.
Security
•	The users log in by academic email owned to Taibah university and strong password.
•	The user's accounts are created by the administrator (GPCommittee).
