# EBD: Database Specification Component


## A4: Conceptual Data Model

In this section, we present the identification of the entities involved and the relationships associated with the TeamSync project, along with its database specification.

### 1. Class diagram

The UML diagram below shows the main entities, the relationships between them and their attributes and multiplicity for TeamSync.

![lbawUml](https://hackmd.io/_uploads/HkoGamXGp.png)


*Figure 1: TeamSync Class Diagram*

### 2. Additional Business Rules


| Identifier | Description |
| --- | --- |
| BR01 | Only one admin can exist.
| BR02 | An administrator cannot ban someone who has already been banned.
| BR03 | An administrator has the ability to unban a user who was previously banned.
| BR04 | An administrator cannot create a project.
| BR05 | An administrator cannot receive invites to projects.
| BR06 | The project coordinator can change the project's visibility from public to private or vice versa during the project's duration.
| BR07 | Only coordinators can invite users to a project.
| BR08 | Coordinators can change the status of any task within a project.
| BR09 | Only coordinators can archieve tasks.
| BR10 | The coordinator cannot invite a user who is already a part of the team.
| BR10 | Only coordinators can change the status of a task to archived.
| BR11 | A notification is generated when someone invites a user to join the project, designates a user as a project coordinator, archives a task, sends a message in the project forum, when a user joins a project, or when they make a comment in a project task.
| BR12 | A user cannot ban or unban someone.
| BR13 | A user must belong to the project in order to be assigned to a task.
| BR14 | A user can only comment on a task within a project they are affiliated with.
| BR15 | A user can only message in a project forum within a project they are affiliated with.
| BR16 | A user can only change the status of a task if they are assigned to it.
| BR18 | A user cannot change the status of an assigned task to archived.
| BR19 | Only the user who authored a comment on the task or a message in a forum can edit it.


*Table 1: TeamSync Aditional Business Rules*

---


## A5: Relational Schema, validation and schema refinement

### 1. Relational Schema

> This artifact comprises the Relational Schema derived from the Conceptual Data Model presented in the preceding artifact, along with the schema's validation. 

| Relation reference | Relation Compact Notation |
| --- | --- |
| R01 | user(<ins>user_id</ins>, name **NN**, username **UK** **NN**, email **UK** **NN**, password **NN**, description, photo, is_admin **NN** **DF** False, is_banned **NN** **DF** False, email_verification **NN** **DF** False). |
| R02 | interest(<ins>interest_id</ins>, interest **NN**) |
| R03 | user_interests(<ins>user_id</ins>->user,<ins>interest_id</ins>->interest) |
| R04 | skill(<ins>skill_id</ins>, skill **NN**) |
| R05 | user_skills(<ins>user_id</ins>->user,<ins>skill_id</ins>->skill) |
| R06 | project(<ins>project_id</ins>, title **NN**, description **NN**, create_date **NN** **CK** create_date <= today, finish_date, is_public **NN** **DF** True, archived **NN** **DF** False, created_by->user **NN**, project_coordinator->user **NN**) |
| R07 | project_users(<ins>project_id</ins>->project, <ins>user_id</ins>->user) |
| R08 | favorite_projects(<ins>project_id</ins>->project, <ins>user_id</ins>->user) |
| R09 | invite(<ins>invite_id</ins>, title **NN**, description **NN**, create_date **NN** **CK** create_date <= today, invite_by->user **NN**, invite_to->user **NN**, project_invite->project **NN**) |
| R10 | task(<ins>task_id</ins>, title **NN**, description **NN**, priority **NN**, create_date **NN** **CK** create_date <= today, finish_date, state **NN** **CK** state IN task_status **DF** open, created_by->user **NN**, assigned_to->user, project_task->project **NN**) |
| R11 | comment(<ins>comment_id</ins>, content **NN**, create_date **NN** **CK** create_date <= today, edited **NN** **DF** False, comment_by->user **NN**, task_comment->task **NN**) |
| R12 | message(<ins>message_id</ins>, content **NN**, create_date **NN** **CK** create_date <= today, edited **NN** **DF** False, message_by->user **NN**, project_message->project **NN**) |
| R13 | notification(<ins>notification_id</ins>, create_date **NN** **CK** create_date <= today, viewed **NN** **DF** False, emited_by->user **NN**, emited_to->user **NN**) |
| R14 | invite_notification(<ins>notification_id</ins>->notification, notifies->invite) |
| R15 | comment_notification(<ins>notification_id</ins>->notification, notifies->comment) |
| R16 | forum_notification(<ins>notification_id</ins>->notification, notifies->message) |
| R17 |assigned_task_notification(<ins>notification_id</ins>->notification, notifies->task) |
| R18 | archieve_task_notification(<ins>notification_id</ins>->notification, notifies->task) |
| R19 | coordinator_notification(<ins>notification_id</ins>->notification, notifies->project) |
| R20 | accepted_invite_notification(<ins>notification_id</ins>->notification, notifies->invite) |

> Legend: UK = UNIQUE KEY, NN = NOT NULL, DF = DEFAULT, CK = CHECK

*Table 2: TeamSync Relational Schema*

### 2. Domains

| Domain Name | Domain Specification |
| --- | --- |
| today | CREATE_DATE DEFAULT CURRENT_DATE|
| task_status  | ENUM ('open', 'assigned', 'completed', 'archived')
| nofication_types  | ENUM ('assignedtask', 'coordinator', 'archivedtask', 'invite', 'forum', 'comment', 'acceptedinvite')



*Table 3: TeamSync Domain*

### 3. Schema validation


| **TABLE R01**| user |
| --- | --- |
| **Keys** | {user_id}, {email}, {username}  |
| **Functional Dependencies:** |       |
| FD0101 | user_id → {username, email, password, description, photo, is_admin, is_banned, email_verification} |
| FD0102 | email → {user_id, username, password, description, photo, is_admin, is_banned, email_verification} |
| FD0103 | username → {user_id, email, password, description, photo, is_admin, is_banned, email_verification} |
| **NORMAL FORM** | BCNF |

*Table 4:  User schema validation*


| **TABLE R02**| interest |
| --- | --- |
| **Keys**| {interest_id}|
| **Functional Dependencies:** | |
| FD0201 | interest_id → {interest} |
| **NORMAL FORM** | BCNF |

*Table 5: interest schema validation*

| **TABLE R03** | user_interests |
| --- | --- |
| **Keys** | {user_id, interest_id}|
| **Functional Dependencies:** | none |
| **NORMAL FORM** | BCNF |

*Table 6: User interface schema validation*

| **TABLE R04** | skill |
| --- | --- |
| **Keys** | {skill_id}|
| **Functional Dependencies:** | |
| FD0401 | skill_Id → {skill} |
| **NORMAL FORM** | BCNF |

*Table 7: Skill schema validation*

| **TABLE R05** | user_skills |
| ---- | --- |
| **Keys** | {user_id, skill_id} |
| **Functional Dependencies:** | none |
| **NORMAL FORM** | BCNF |

*Table 8: User skills schema validation*

| **TABLE R06** | project |
| --- | --- |
| **Keys** | {project_id} |
| **Functional Dependencies:** | |
| FD0601 | project_id → {title, description, is_public, archived, create_date, finish_date, created_by, project_coordinator} |
| **NORMAL FORM** | BCNF |

*Table 9: Project schema validation*

| **TABLE R07** | project_users |
| --- | --- |
| **Keys** | {user_id, project_id} |
| **Functional Dependencies:** |none |
| **NORMAL FORM** | BCNF |

*Table 10: Project users schema validation*

| **TABLE R08** | favorite_projects |
| --- | --- |
| **Keys** | {user_id, project_id} |
| **Functional Dependencies:** |none      |
| **NORMAL FORM** | BCNF |

*Table 11: Favorite projects schema validation*

| **TABLE R09** | invite |
| --- | --- |
| **Keys** | {invite_id} |
| **Functional Dependencies:** | |
| FD0901 | invite_id → {title, title, description, create_date, invite_by, invite_to, project_invite} |
| **NORMAL FORM** | BCNF |

*Table 12: Invite schema validation*

| **TABLE R10** | task |
| --- | --- |
| **Keys** | {task_id} |
| **Functional Dependencies:** | |
| FD01001 | task_id → {title, description, priority, create_date, finish_date, state, created_by, assigned_to, project_task} |
| **NORMAL FORM** | BCNF |

*Table 13: Task schema validation*

| **TABLE R11** | comment |
| --- | --- |
| **Keys** | {comment_id}|
| **Functional Dependencies:** | |
| FD01101 | comment_id → {content, create_date, edited, comment_by, task_comment} |
| **NORMAL FORM** | BCNF |

*Table 14: Comment schema validation*

| **TABLE R12** | message |
| --- | --- |
| **Keys** | {message_id} |
| **Functional Dependencies:** | |
| FD1201 | message_id → {content, create_date, edited, message_by, project_message} |
| **NORMAL FORM** | BCNF |

*Table 15: Message schema validation*

| **TABLE R13** | notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1301 | notification_id → {create_date, viewed, emited_by, emited_to} |
| **NORMAL FORM** | BCNF |

*Table 16: Notification schema validation*

| **TABLE R14** | invite_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1401 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 17: Invite notification schema validation*

| **TABLE R15** | coordinator_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1501 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 18: Coordinator notification schema validation*

| **TABLE R16** | archive_task_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1601 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 19: Archive task notification schema validation*

| **TABLE R17** | assigned_task_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1701 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 20: Assigned task notification schema validation*

| **TABLE R18** | forum_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1801 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 21: Forum notification schema validation*

| **TABLE R19** | accepted_invite_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD1901 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 22: Accepted invite notification schema validation*

| **TABLE R20** | comment_notification |
| --- | --- |
| **Keys** | {notification_id} |
| **Functional Dependencies:** | |
| FD2001 | notification_id → {notifies} |
| **NORMAL FORM** | BCNF |

*Table 23: Comment notification schema validation*


Since all relations are in Boyce–Codd Normal Form (BCNF), the relational schema is inherently in BCNF as well, and consequently, no further normalization of the schema is necessary.


---


## A6: Indexes, triggers, transactions and database population

>This artifact encompasses the comprehensive database workload, the physical structure of the database, its indexes, triggers, and transactions essential for maintaining data integrity. Additionally, it comprises the entire database creation script, complete with indexes and triggers.

### 1. Database Workload

To facilitate the development of a well-designed database, it is imperative to have a deep understanding of how tables will evolve and how frequently they will be accessed. The table below provides a glimpse into these forecasts:

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| -----| ------------- | ------------ | -------- |
| R01  | user | 10k |  dozens per day |
| R02  | interest |  100 | no growth |
| R03  | user_interest | 20k | dozens per day |
| R04  | skill | 100 | no growth |
| R05  | user_skills | 20k | dozens per day |
| R06  | project | 1k | dozens per month |
| R07  | project_users | 10k | hundreds per month |
| R08  | favorite_project | 100 | dozens per month |
| R09  | invite | 10k | hundreds per month |
| R10  | task | 5k | hundreds per month |
| R11  | comment | 1k | hundreds per month |
| R12  | message | 5k | hundreds per month |
| R13  | notification | 10k | thousands per month |



*Table 24: TeamSync workload*


### 2. Proposed Indices
> Indexes play a crucial role in enhancing database performance by expediting the retrieval of specific rows. When an index is created on a column involved in join conditions, it can notably accelerate queries that involve joins. Furthermore, indexes can also bring efficiency to UPDATE and DELETE commands when they involve search conditions.

#### 2.1. Performance Indices
 
| **Index**           | IDX01 |
| ---                 | ---   |
| **Relation**        | users |
| **Attribute**       | name  |
| **Type**            | B-tree |
| **Cardinality**     | medium |
| **Clustering**      | yes |
| **Justification**   | The users table is frequently used for SELECT and not frequently used for UPDATE  so it is a perfect candidate for an index that would improve performance using a B-tree |
| **SQL code** | `CREATE INDEX users_username ON users USING btree(name); CLUSTER users USING users_name;` |

*Table 25: Username Index*

| **Index**           | IDX02 |
| ---                 | --- |
| **Relation**        | notification |
| **Attribute**       | emitted_by  |
| **Type**            | B-tree |
| **Cardinality**     | medium |
| **Clustering**      | yes |
| **Justification**   | Since we have a lot of notifications, searching them using an index will improve performance using a B-tree and a cluster. UPDATE frequency is loe and cardinality is medium. |
| **SQL code** | `CREATE INDEX emitedBy_notification ON notification USING btree(emitedBy); CLUSTER notification USING emitedBy_notification; ` |

*Table 26: EmittedBy User Index*

| **Index**           | IDX03 |
| ---                 | --- |
| **Relation**        | notification |
| **Attribute**       | emitted_to  |
| **Type**            | B-tree |
| **Cardinality**     | medium |
| **Clustering**      | yes |
| **Justification**   | Since we have a lot of notifications, searching them using an index will improve performance using a B-tree and a cluster. UPDATE frequency is loe and cardinality is medium. |
| **SQL code**  | `CREATE INDEX emitedTo_notification ON notification USING btree(emitedTo); CLUSTER notification USING emitedTo_notification;` |

*Table 27: EmittedTo User Index*

| **Index**           | IDX04 |
| ---                 | --- |
| **Relation**        | message |
| **Attribute**       | project_message |
| **Type**            | B-tree |
| **Cardinality**     | medium |
| **Clustering**      | yes |
| **Justification**   | Since we have a lot of messages, searching them using an index will improve performance using a B-tree and a cluster. UPDATE frequency is loe and cardinality is medium. |
| **SQL code** | `CREATE INDEX projectMessage_message ON message USING btree(projectMessage); CLUSTER message USING projectMessage_message;` |

*Table 28: Project Message Index*

| **Index**           | IDX05 |
| ---                 | --- |
| **Relation**        | task |
| **Attribute**       | project_task |
| **Type**            | hash |
| **Cardinality**     | medium |
| **Clustering**      | no |
| **Justification**   | Since we have a lot of tasks in every project, searching them using an index will improve performance using a hash. UPDATE frequency is loe and cardinality is medium. |
| **SQL code** | `CREATE INDEX projectTask_task ON task USING hash(projectTask);` |

*Table 29: Project Task Index*

| **Index**           | IDX06                                  |
| ---                 | ---                                    |
| **Relation**        | comment |
| **Attribute**       | task_comment |
| **Type**            | hash              |
| **Cardinality**     | medium |
| **Clustering**      | no                |
| **Justification**   | Since we have a lot of tasks in every project and every task needs to have comments associated, searching the comments using an index will improve performance using a hash. UPDATE frequency is loe and cardinality is medium. |
| **SQL code** | ` CREATE INDEX task_Comment ON comment USING hash(taskComment);` |

*Table 30: Task Comment Index*

#### 2.2. Full-text Search Indices 

> Triggers are a valuable tool for upholding integrity rules that cannot be easily enforced through simpler means. They are identified and described by specifying the triggering event, the conditions that must be met, and the activation code to be executed. Additionally, triggers are employed to ensure the real-time maintenance of full-text indexes.
> 
| **Index** | IDX07 |
| --- | ---  |
| **Relation** | users |
| **Attribute** | username and name |
| **Type** | GIN |
| **Clustering** | no |
| **Justification** | Matching the usernames and names while searching for users . The index type is GIN because the indexed fields are not expected to change often.|


> SQL code:
``` sql 
ALTER TABLE users ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS trigger AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
        RETURN NEW;
    END IF;

IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name OR NEW.username <> OLD.username THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
    END $$ LANGUAGE plpgsql;

CREATE TRIGGER user_search_update BEFORE INSERT OR UPDATE ON users
    FOR EACH ROW EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search_idx ON users USING GIN(tsvectors); 
``` 
*Table 31: Users Full-text Search Index*

| **Index**           | IDX08                                  |
| ---                 | ---                                    |
| **Relation**        | project    |
| **Attribute**       | title, description   |
| **Type**            | GIN              |
| **Clustering**      | no                |
| **Justification**   |  Matching the titles and descriptions while searching for projects . The index type is GIN because the indexed fields are not expected to change often.  |
> SQL code: 
``` sql
ALTER TABLE project ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION project_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER project_search_update BEFORE INSERT OR UPDATE ON project
    FOR EACH ROW EXECUTE PROCEDURE project_search_update();

CREATE INDEX project_search_idx ON project USING GIN(tsvectors);
```

*Table 32: Project Full-text Search Index*

| **Index**           | IDX09                                  |
| ---                 | ---                                    |
| **Relation**        | task    |
| **Attribute**       | title, description   |
| **Type**            | GIN              |
| **Clustering**      | no                |
| **Justification**   |  Matching the titles and description while searching for tasks . The index type is GIN because the indexed fields are not expected to change often.  |
> SQL code:
```sql
ALTER TABLE task ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION task_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

create TRIGGER task_search_update BEFORE INSERT OR UPDATE ON task
    FOR EACH ROW EXECUTE PROCEDURE task_search_update();

CREATE INDEX task_search_idx ON task USING GIN(tsvectors);
```

*Table 33: Task Full-text Search Index*


### 3. Triggers
 
> Triggers are employed to uphold complex integrity rules that cannot be efficiently accomplished through simpler means, and they are characterized by outlining the triggering event, the conditional criteria, and the corresponding action code.


| **TRIGGER01**    | invite_notification |
| ---              | --- |
| **Description**  | If someone invites a user to a project, he receives a notification. |
> SQL code:
``` sql
CREATE FUNCTION invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.invited_by, NEW.invited_to , 'invite', NEW.invite_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_notification
    AFTER INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_notification();
```

*Table 34: Invite Notification Trigger*


| **TRIGGER02**    | coordinator_notification |
| ---              | --- |
| **Description**  | When the project coordinator changes, a notification is generated for all project members. |
> SQL code:
```sql
CREATE FUNCTION coordinator_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN 
    IF NEW.project_coordinator <> OLD.project_Coordinator THEN
        FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = NEW.project_id) LOOP
            INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
            VALUES ('2022-11-25', FALSE, NEW.project_coordinator, userslist, 'coordinator', NEW.project_id);
        END LOOP;
    END IF;
    
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_notification
    AFTER UPDATE ON project
    FOR EACH ROW
    EXECUTE FUNCTION coordinator_notification();

```

*Table 35: Coordinator Notification Trigger*


| **Trigger03**    | archivedtask_notification |
| ---              | ---                                    |
| **Description**  | When a task is archived by the project coordinator, the user that is assigned to the task gets a notification |
> SQL code:
```sql
CREATE FUNCTION archivedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.state = 'archived' AND NEW.state <> OLD.state THEN
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
        VALUES ('2022-11-03', FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'archivedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER archivedtask_notification
    AFTER UPDATE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE archivedtask_notification();
```

*Table 36: Archived Task Notification Trigger*

| **Trigger04**    | assignedtask_notification |
| ---              | ---                                    |
| **Description**  | When a task is assigned to a user by the project coordinator, the user that is assigned gets a notification. |
> SQL code:
```sql
CREATE FUNCTION assignedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (OLD.assigned_to IS NULL AND NEW.assigned_to IS NOT NULL) OR
    (OLD.assigned_to IS NOT NULL AND NEW.assigned_to IS NOT NULL AND NEW.assigned_to <> OLD.assigned_to) THEN 
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'assignedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER assignedtask_notification
        AFTER UPDATE ON task
        FOR EACH ROW
        EXECUTE PROCEDURE assignedtask_notification();
```

*Table 37: Assigned Task Notification Trigger*

| **Trigger05**    | acceptedinvite_notification |
| ---              | ---      |
| **Description**  | When a user accepts an invite to a project, all project members get a notification. |
> SQL code:
```sql
CREATE FUNCTION acceptedinvite_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = New.project_id AND user_id <> NEW.user_id) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_id = project_id), userslist, 'acceptedinvite', NEW.project_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER acceptedinvite_notification
        AFTER INSERT ON project_users
        FOR EACH ROW
        EXECUTE PROCEDURE acceptedinviteNotification();
```

*Table 38: Accepted Invite Notification Trigger*

| **Trigger06**    | comment_notification |
| ---              | ---                                    |
| **Description**  | When a user comments on a task that is assigned to someone, the user that is assigned to the task gets a notification. |
> SQL code:
```sql
CREATE FUNCTION comment_notification() RETURNS TRIGGER AS
$BODY$
BEGIN 
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.comment_by , (SELECT assigned_to FROM task WHERE NEW.task_comment = task_id), 'comment', NEW.comment_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_notification
        AFTER INSERT ON comment
        FOR EACH ROW
        EXECUTE PROCEDURE comment_notification();
```

*Table 39: Comment Notification Trigger*

| **Trigger07**    | forum_notification |
| ---              | ---                                    |
| **Description**  | When a user sends a message to the forum of a project, all project members get a notification. |
> SQL code:
```sql
CREATE FUNCTION forum_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (
        SELECT user_id FROM project_users WHERE project_id = New.project_message AND user_id <> NEW.message_by
        UNION
        SELECT project_coordinator FROM project WHERE project_id = NEW.project_message
        ) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
            FALSE, NEW.message_by, userslist, 'forum', NEW.message_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER forum_notification
        AFTER INSERT ON message
        FOR EACH ROW
        EXECUTE PROCEDURE forum_notification();
```

*Table 40: Forum Notification Trigger*

| **Trigger08**    | admin_create_proj |
| ---              | --- |
| **Description**  | An administrator cannot create a project . |
> SQL code:
```sql
CREATE FUNCTION admin_create_proj() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM users WHERE is_admin = TRUE AND NEW.created_by = user_id) THEN
        RAISE EXCEPTION 'An administrator cannot create a project.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER admin_create_proj
    BEFORE INSERT ON project
    FOR EACH ROW
    EXECUTE PROCEDURE admin_create_proj();
```

*Table 41: Administrator Create Project Trigger*

| **Trigger09** | invite_user_in_project |
| ---              | ---                                    |
| **Description**  | The coordinator cannot invite a user who is already a part of the team. |
> SQL code:
```sql
CREATE FUNCTION invite_user_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.project_invite = project_id AND NEW.invited_to = user_id) THEN
        RAISE EXCEPTION 'The user you want to invte is already on the project team.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_user_in_project
    BEFORE INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_user_in_project();
```

*Table 42: Invite User In Project Trigger*

| **Trigger10**    | coordinator_not_in_project |
| ---              | ---                                    |
| **Description**  | The coordinator cannot be part of project as a worker. |
> SQL code:
```sql
CREATE FUNCTION coordinator_not_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.user_id = (select project_coordinator from project where NEW.project_id = project_id)) THEN
        RAISE EXCEPTION 'The coordinator cannot be part of project as a worker';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_not_in_project
    BEFORE INSERT ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE coordinator_not_in_project();
```

*Table 43: Coordinator Not In Project As User Trigger*

| **Trigger11**   | comment_unassigned_or_archived_task |
| ---              | ---                                    |
| **Description**  | A user cannot comment on a task that is not assigned to someone or is archived. |
> SQL code:
```sql
CREATE FUNCTION comment_unassigned_or_archived_task() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM task WHERE task_id = NEW.task_comment AND (assigned_to IS NULL OR state = 'archived')) THEN
        RAISE EXCEPTION 'User cannot comment on a task that is not assigned to someone or is archived';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_unassigned_or_archived_task
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_unassigned_or_archived_task();
```

*Table 44: Comment Unassigned Or Archived Task Trigger*

| **Trigger12**    | update_tasks_on_user_leave |
| ---              | ---                                    |
| **Description**  | Update tasks details when a user leaves a project. |
> SQL code:
```sql
CREATE FUNCTION update_tasks_on_user_leave() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE task
    SET state = 'open', assigned_to = NULL
    WHERE project_task = OLD.project_id
    AND ((state = 'assigned' OR state = 'closed') AND assigned_to = OLD.user_id);
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_tasks_on_user_leave
    AFTER DELETE ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE update_tasks_on_user_leave();
```

*Table 45: Update Tasks On User Leave Trigger*

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| TRANS01  | Get tasks of current projects          |
| --------------- | ----------------------------------- |
| Justification   | Within the transaction, it's possible for new rows to be inserted into the project table. This situation can lead to variations in the data retrieved by both SELECT statements, potentially causing what is referred to as a "Phantom Read." The transaction is configured as READ ONLY since it exclusively employs SELECT statements and doesn't involve any data modification operations.  |
| Isolation level | SERIALIZABLE READ ONLY |
> SQL code:
```sql
BEGIN TRANSACTION;
    SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

    SELECT COUNT(*)
    FROM project
    WHERE now() < project.finish_date AND now() > project.create_date;

    SELECT proj.title, ta.title
    FROM task ta
    INNER JOIN task t ON t.task_id = ta.task_id
    INNER JOIN project proj ON proj.project_id = ta.project_task
    WHERE now() < proj.finish_date AND now() > proj.create_date;

END TRANSACTION;
```

*Table 46: Transaction*

| TRANS02   | Insertion of user in projects |
| --------------- | ----------------------------------- |
| Justification   | To uphold data consistency, transactions are essential to guarantee error-free execution of all code. In the event of an error, a ROLLBACK is triggered, particularly when a project insertion fails. This transaction operates under the Repeatable Read isolation level to prevent potential issues like concurrent updates to the project_id, which could otherwise lead to inconsistent data being stored. |
| Isolation level | REPEATABLE READ |
> SQL code:
```sql
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

INSERT INTO project (title, description, is_public, archived, create_date, finish_date, created_by, project_coordinator)
VALUES ($title, $description, $is_public, $archived, $create_date, $finish_date, $created_by, $project_coordinator);


INSERT INTO project_user (project_id, user_id)
VALUES (currval('project_id'), $user_id);


END TRANSACTION;
```

*Table 46: Insertion of user in projects Transaction*


## Annex A. SQL Code

In the project repository you can access [database.sql](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/blob/main/SQL/database.sql) and [populate.sql](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23117/-/blob/main/SQL/populate.sql).

### A.1. Database schema

```sql
create schema if not exists lbaw23117;
SET search_path TO lbaw23117;

-----------------------------------------
-- Drop old schema
-----------------------------------------

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS interest CASCADE;
DROP TABLE IF EXISTS user_interests CASCADE;
DROP TABLE IF EXISTS skill CASCADE;
DROP TABLE IF EXISTS user_skills CASCADE;
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS project_users CASCADE;
DROP TABLE IF EXISTS favorite_projects CASCADE;
DROP TABLE IF EXISTS invite CASCADE;
DROP TABLE IF EXISTS task CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS message CASCADE;
DROP TABLE IF EXISTS notification CASCADE;

DROP TYPE IF EXISTS task_status;
DROP TYPE IF EXISTS notification_types;

DROP FUNCTION IF EXISTS invite_notification;
DROP FUNCTION IF EXISTS coordinator_notification;
DROP FUNCTION IF EXISTS archivedtask_notification;
DROP FUNCTION IF EXISTS assignedtask_notification;
DROP FUNCTION IF EXISTS acceptedinvite_notification;
DROP FUNCTION IF EXISTS comment_notification;
DROP FUNCTION IF EXISTS forum_notification;
DROP FUNCTION IF EXISTS invite_user_in_project;
DROP FUNCTION IF EXISTS admin_create_proj;
DROP FUNCTION IF EXISTS coordinator_not_in_project;
DROP FUNCTION IF EXISTS update_tasks_on_user_leave;
DROP FUNCTION IF EXISTS comment_unassigned_or_archived_task;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE task_status AS ENUM ('open', 'assigned', 'closed', 'archived');
CREATE TYPE notification_types as ENUM('assignedtask', 'coordinator', 'archivedtask', 'invite', 'forum', 'comment', 'acceptedinvite');

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    description TEXT,
    photo TEXT, 
    is_admin BOOLEAN NOT NULL DEFAULT FALSE, 
    is_banned BOOLEAN NOT NULL DEFAULT FALSE,
    email_verification BOOLEAN NOT NULL DEFAULT FALSE 
);

CREATE TABLE interest (
    interest_id SERIAL PRIMARY KEY,
    interest TEXT NOT NULL 
);

CREATE TABLE user_interests(
    user_id INTEGER REFERENCES users (user_id) ON UPDATE CASCADE,
    interest_id INTEGER REFERENCES interest (interest_id) ON UPDATE CASCADE,
    PRIMARY KEY (user_id, interest_id)
);

CREATE TABLE skill (
    skill_id SERIAL PRIMARY KEY,
    skill TEXT NOT NULL 
);

CREATE TABLE user_skills(
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE,
    skill_id INTEGER REFERENCES skill(skill_id) ON UPDATE CASCADE,
    PRIMARY KEY (user_id, skill_id)
); 

CREATE TABLE project (
    project_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    is_public BOOLEAN NOT NULL DEFAULT TRUE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,
    create_date TIMESTAMP NOT NULL CHECK(create_date <= now()),
    finish_date TIMESTAMP,
    created_by INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    project_coordinator INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE
);

CREATE TABLE project_users (
    project_id INTEGER REFERENCES project(project_id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE,
    PRIMARY KEY (project_id, user_id)
);

CREATE TABLE favorite_projects (
    project_id INTEGER REFERENCES project(project_id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE,
    PRIMARY KEY (project_id, user_id)
);

CREATE TABLE invite (
    invite_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    invited_by INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    invited_to INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    project_invite INTEGER NOT NULL REFERENCES project(project_id) ON UPDATE CASCADE
);

CREATE TABLE task (
    task_id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    priority TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK(create_date <= now()),
    finish_date TIMESTAMP,
    state task_status NOT NULL DEFAULT 'open',
    create_by INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    assigned_to INTEGER REFERENCES users(user_id) ON UPDATE CASCADE,
    project_task INTEGER REFERENCES project(project_id) ON UPDATE CASCADE 
);
    
CREATE TABLE comment (
    comment_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    comment_by INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    task_comment INTEGER NOT NULL REFERENCES task(task_id) ON UPDATE CASCADE
);

CREATE TABLE message (
    message_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    create_date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    edited BOOLEAN NOT NULL DEFAULT FALSE,
    message_by INTEGER REFERENCES users(user_id) ON UPDATE CASCADE,
    project_message INTEGER REFERENCES project(project_id) ON UPDATE CASCADE
);

CREATE TABLE notification (
    notification_id SERIAL PRIMARY KEY,
    create_Date TIMESTAMP NOT NULL CHECK (create_date <= now()),
    viewed BOOLEAN NOT NULL DEFAULT FALSE,
    emited_by INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE, 
    emited_to INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    type notification_types NOT NULL,
    reference_id INTEGER NOT NULL
);


-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX users_username ON users USING btree(username);
CLUSTER users USING users_username;

CREATE INDEX emitedBy_notification ON notification USING btree(emitedBy);
CLUSTER notification USING emitedBy_notification;

CREATE INDEX emitedTo_notification ON notification USING btree(emitedTo);
CLUSTER notification USING emitedTo_notification;

CREATE INDEX projectMessage_message ON message USING btree(projectMessage);
CLUSTER message USING projectMessage_message;

CREATE INDEX projectTask_task ON task USING hash(projectTask);

CREATE INDEX task_comment ON comment USING hash(taskComment);


-----------------------------------------
-- TRIGGERS
-----------------------------------------

--TRIGGER01 (Invite Notification)
CREATE FUNCTION invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.invited_by, NEW.invited_to , 'invite', NEW.invite_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_notification
    AFTER INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_notification();


--TRIGGER02 (Coordinator Notification)
CREATE FUNCTION coordinator_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN 
    IF NEW.project_coordinator <> OLD.project_Coordinator THEN
        FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = NEW.project_id) LOOP
            INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
            VALUES ('2022-11-25', FALSE, NEW.project_coordinator, userslist, 'coordinator', NEW.project_id);
        END LOOP;
    END IF;
    
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_notification
    AFTER UPDATE ON project
    FOR EACH ROW
    EXECUTE FUNCTION coordinator_notification();



--TRIGGER03 (Archieve Task Notification)
CREATE FUNCTION archivedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.state = 'archived' AND NEW.state <> OLD.state THEN
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id)
        VALUES ('2022-11-03', FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'archivedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER archivedtask_notification
    AFTER UPDATE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE archivedtask_notification();



--TRIGGER04 (Assigned Task Notification)
CREATE FUNCTION assignedtask_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (OLD.assigned_to IS NULL AND NEW.assigned_to IS NOT NULL) OR
    (OLD.assigned_to IS NOT NULL AND NEW.assigned_to IS NOT NULL AND NEW.assigned_to <> OLD.assigned_to) THEN 
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_task = project_id), NEW.assigned_to, 'assignedtask', NEW.task_id);
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER assignedtask_notification
        AFTER UPDATE ON task
        FOR EACH ROW
        EXECUTE PROCEDURE assignedtask_notification();



--TRIGGER05 (Accepted Invite Notification)
CREATE FUNCTION acceptedinvite_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (SELECT user_id FROM project_users WHERE project_id = New.project_id AND user_id <> NEW.user_id) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES ('2022-11-03', 
            FALSE, (SELECT project_coordinator from project WHERE NEW.project_id = project_id), userslist, 'acceptedinvite', NEW.project_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER acceptedinvite_notification
        AFTER INSERT ON project_users
        FOR EACH ROW
        EXECUTE PROCEDURE acceptedinviteNotification();



--TRIGGER06 (Comment Notification)
CREATE FUNCTION comment_notification() RETURNS TRIGGER AS
$BODY$
BEGIN 
    INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
        FALSE, NEW.comment_by , (SELECT assigned_to FROM task WHERE NEW.task_comment = task_id), 'comment', NEW.comment_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_notification
        AFTER INSERT ON comment
        FOR EACH ROW
        EXECUTE PROCEDURE comment_notification();



--TRIGGER07 (Forum Notification)
CREATE FUNCTION forum_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    userslist INTEGER;
BEGIN
    FOR userslist IN (
        SELECT user_id FROM project_users WHERE project_id = New.project_message AND user_id <> NEW.message_by
        UNION
        SELECT project_coordinator FROM project WHERE project_id = NEW.project_message
        ) LOOP
        INSERT INTO notification (create_date, viewed, emited_by, emited_to, type, reference_id) VALUES (NEW.create_date, 
            FALSE, NEW.message_by, userslist, 'forum', NEW.message_id);
    END LOOP;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER forum_notification
        AFTER INSERT ON message
        FOR EACH ROW
        EXECUTE PROCEDURE forum_notification();



--TRIGGER08 (An admin cannot create a project)
CREATE FUNCTION admin_create_proj() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM users WHERE is_admin = TRUE AND NEW.created_by = user_id) THEN
        RAISE EXCEPTION 'An administrator cannot create a project.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER admin_create_proj
    BEFORE INSERT ON project
    FOR EACH ROW
    EXECUTE PROCEDURE admin_create_proj();


--TRIGGER09 (The coordinator cannot invite a user who is already a part of the team)
CREATE FUNCTION invite_user_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.project_invite = project_id AND NEW.invited_to = user_id) THEN
        RAISE EXCEPTION 'The user you want to invte is already on the project team.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER invite_user_in_project
    BEFORE INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE invite_user_in_project();


--TRIGGER10 (The coordinator cannot be part of project as a worker)
CREATE FUNCTION coordinator_not_in_project() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM project_users WHERE NEW.user_id = (select project_coordinator from project where NEW.project_id = project_id)) THEN
        RAISE EXCEPTION 'The coordinator cannot be part of project as a worker';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_not_in_project
    BEFORE INSERT ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE coordinator_not_in_project();

--TRIGGER11 (User cannot comment on a task that is not assigned to someone or is archived)
CREATE FUNCTION comment_unassigned_or_archived_task() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM task WHERE task_id = NEW.task_comment AND (assigned_to IS NULL OR state = 'archived')) THEN
        RAISE EXCEPTION 'User cannot comment on a task that is not assigned to someone or is archived';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_unassigned_or_archived_task
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_unassigned_or_archived_task();


--TRIGGER12 (Update tasks when a user leaves a project)
CREATE FUNCTION update_tasks_on_user_leave() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE task
    SET state = 'open', assigned_to = NULL
    WHERE project_task = OLD.project_id
    AND ((state = 'assigned' OR state = 'closed') AND assigned_to = OLD.user_id);
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_tasks_on_user_leave
    AFTER DELETE ON project_users
    FOR EACH ROW
    EXECUTE PROCEDURE update_tasks_on_user_leave();

-----------------------------------------
-- FULL-TEXT SEARCH INDEXES
----------------------------------------
--Full-text search index 1 -> for the users based on matching names and usernames

ALTER TABLE users ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS trigger AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name OR NEW.username <> OLD.username THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.username, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER user_search_update BEFORE INSERT OR UPDATE ON users
    FOR EACH ROW EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search__idx ON users USING GIN(tsvectors);


--Full-text search index 2 -> for the projects based on matching titles and descriptions

ALTER TABLE project ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION project_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER project_search_update BEFORE INSERT OR UPDATE ON project
    FOR EACH ROW EXECUTE PROCEDURE project_search_update();

CREATE INDEX project_search__idx ON project USING GIN(tsvectors);

-- Full-text search index 3 -> for the tasks based on matching titles and descriptions

ALTER TABLE task ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION task_search_update() RETURNS trigger AS $$

BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors :=
            setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
        RETURN NEW;
    END IF;

    IF TG_OP = 'UPDATE' THEN
        IF NEW.title <> OLD.title OR NEW.description <> OLD.description THEN
            NEW.tsvectors :=
                setweight(to_tsvector('english', coalesce(NEW.title, '')), 'A') ||
                setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B');
            RETURN NEW;
        END IF;
    END IF;

    RETURN NULL;
END $$ LANGUAGE plpgsql;

create TRIGGER task_search_update BEFORE INSERT OR UPDATE ON task
    FOR EACH ROW EXECUTE PROCEDURE task_search_update();

CREATE INDEX task_search__idx ON task USING GIN(tsvectors);

-----------------------------------------
-- end
-----------------------------------------
```

### A.2. Database population

```sql
-----------------------------------------
-- Populate the database
-----------------------------------------

SET search_path TO lbaw23117;

INSERT INTO users (name, username, email, password, description, photo, is_admin, is_banned, email_verification) VALUES
('Alice Johnson', 'alicej', 'alice@example.com', 'securepwd123', 'User account for Alice', 'alice.jpg', TRUE, FALSE, TRUE),
('Bob Smith', 'bobsmith', 'bob@example.com', 'bobspassword456', 'User account for Bob', 'bob.jpg', FALSE, FALSE, TRUE),
('Charlie Brown', 'charlieb', 'charlie@example.com', 'strongpwd789', 'User account for Charlie', 'charlie.jpg', FALSE, FALSE, TRUE),
('Dav_id Wilson', 'dav_idw', 'dav_id@example.com', 'dav_idpass4321', 'User account for Dav_id', 'dav_id.jpg', FALSE, FALSE, TRUE),
('Eve Anderson', 'evea', 'eve@example.com', 'password1234', 'User account for Eve', 'eve.jpg', FALSE, FALSE, TRUE),
('Frank Miller', 'frankm', 'frank@example.com', 'millerpwd567', 'User account for Frank', 'frank.jpg', FALSE, FALSE, TRUE),
('Grace Martinez', 'gracem', 'grace@example.com', 'grace12345', 'User account for Grace', 'grace.jpg', FALSE, FALSE, TRUE),
('Henry Davis', 'henryd', 'henry@example.com', 'davishash123', 'User account for Henry', 'henry.jpg', FALSE, FALSE, TRUE),
('Ivy Taylor', 'ivyt', 'ivy@example.com', 'ivysecurepwd', 'User account for Ivy', 'ivy.jpg', FALSE, FALSE, TRUE),
('Jack Adams', 'jacka', 'jack@example.com', 'jackpass789', 'User account for Jack', 'jack.jpg', FALSE, FALSE, TRUE),
('Karen White', 'karenw', 'karen@example.com', 'karenpassword', 'User account for Karen', 'karen.jpg', FALSE, FALSE, TRUE),
('Liam Scott', 'liams', 'liam@example.com', 'liam123456', 'User account for Liam', 'liam.jpg', FALSE, FALSE, TRUE),
('Mia Turner', 'miat', 'mia@example.com', 'mia7890pwd', 'User account for Mia', 'mia.jpg', FALSE, FALSE, TRUE),
('Noah Lewis', 'noahl', 'noah@example.com', 'noahpass123', 'User account for Noah', 'noah.jpg', FALSE, FALSE, TRUE),
('Olivia Hall', 'oliviah', 'olivia@example.com', 'secureolivia', 'User account for Olivia', 'olivia.jpg', FALSE, FALSE, TRUE),
('Peter Baker', 'peterb', 'peter@example.com', 'peterpwd2021', 'User account for Peter', 'peter.jpg', FALSE, FALSE, TRUE),
('Quinn King', 'quinnk', 'quinn@example.com', 'kingpwd123', 'User account for Quinn', 'quinn.jpg', FALSE, FALSE, TRUE),
('Riley Garcia', 'rileyg', 'riley@example.com', 'rileypassword', 'User account for Riley', 'riley.jpg', FALSE, FALSE, TRUE),
('Sophia Allen', 'sophiaa', 'sophia@example.com', 'allen1234', 'User account for Sophia', 'sophia.jpg', FALSE, FALSE, TRUE),
('Thomas Wright', 'thomasw', 'thomas@example.com', 'pwdfortom', 'User account for Thomas', 'thomas.jpg', FALSE, FALSE, TRUE);


INSERT INTO interest (interest) VALUES
('Coding'),
('Web Development'),
('Machine Learning'),
('Open Source'),
('Data Science'),
('Problem Solving'),
('V_ideo Games'),
('AI and Robotics'),
('Blockchain'),
('Cybersecurity'),
('DevOps'),
('Cloud Computing'),
('Agile Methodology'),
('Hackathons'),
('Tech Conferences'),
('Programming Competitions'),
('Linux');


INSERT INTO user_interests (user_id, interest_id) VALUES 
(1, 1),
(1, 4),
(1, 7),
(2, 12),
(2, 15),
(3, 13),
(3, 16),
(4, 2),
(4, 9),
(5, 10),
(5, 11),
(6, 3),
(6, 5),
(7, 6),
(7, 8),
(8, 12),
(8, 13),
(9, 14),
(9, 1),
(10, 15),
(10, 17),
(11, 12),
(11, 15),
(12, 13), 
(12, 16),
(13, 13), 
(13, 16),
(14, 12), 
(14, 4),
(15, 3),
(15, 12), 
(16, 1), 
(16, 16),
(17, 7),
(17, 8),
(18, 17),
(18, 9),
(19, 9),
(19, 4),
(20, 11),
(20, 10);

INSERT INTO skill (skill) VALUES 
('Programming'),
('Web Development'),
('Database Management'),
('Graphic Design'),
('Data Analysis'),
('Project Management'),
('Marketing'),
('Cybersecurity'),
('DevOps'),
('IT Support'),
('Software Development'),
('Data Science');


INSERT INTO user_skills (user_id, skill_id) VALUES 
(2, 4),
(2, 7),
(3, 3),
(3, 2),
(4, 10),
(4, 8),
(5, 1),
(5, 12),
(6, 5),
(6, 6),
(7, 9),
(7, 7),
(8, 11),
(8, 6),
(9, 8),
(9, 7),
(10, 2),
(10, 4),
(11, 5),
(11, 1),
(12, 3),
(12, 7),
(13, 10),
(13, 1),
(14, 5),
(14, 10),
(15, 12),
(15, 6),
(16, 5),
(16, 11),
(17, 1),
(17, 9),
(18, 10),
(18, 2),
(19, 7),
(19, 4),
(20, 8),
(20, 3);


INSERT INTO project (title, description, is_public, archived, create_date, finish_date, created_by, project_coordinator) VALUES
('Website Redesign', 'Redesign our company website to improve user experience and visual appeal.', FALSE, FALSE, '2022-10-21', '2022-11-30', 2, 2),
('Marketing Campaign for New Product', 'Plan and execute a marketing campaign for our upcoming product launch.', TRUE, FALSE, '2022-10-20', '2022-12-15', 3, 3),
('Customer Support Enhancement', 'Improve our customer support system to prov_ide better assistance to our clients.', TRUE, FALSE, '2022-10-20', NULL, 5, 5),
('Sales Optimization Strategy', 'Develop a strategy to optimize our sales processes and increase revenue.', FALSE, FALSE, '2022-10-12','2022-11-30', 7, 7),
('E-commerce Website Development', 'Create an e-commerce platform for our online store with secure payment processing.', TRUE, FALSE, '2022-9-25', '2022-12-20', 9, 9),
('Content Marketing Plan', 'Plan and execute a content marketing strategy to enhance brand visibility.', TRUE, FALSE, '2022-10-13', '2022-11-30', 11, 11), 
('Data Analysis for Market Insights', 'Analyze market data to prov_ide insights and improve decision-making.', FALSE, FALSE, '2022-10-14', '2022-12-15', 13, 13),
('Social Media Engagement Campaign', 'Increase social media engagement and grow our online presence.', FALSE, TRUE, '2022-10-20', NULL, 15, 15),
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', TRUE, FALSE, '2022-09-29', '2022-11-30',17, 17),
('Content Creation and Publishing', 'Create and publish engaging content to boost brand awareness and user engagement.',TRUE, FALSE, '2022-09-30', '2022-12-31', 19, 19),
('Mobile App Development', 'Develop a mobile app to prov_ide our users with a better mobile experience.', TRUE, FALSE, '2022-09-01', NULL, 2, 2),
('Product Inventory Management', 'Implement a system to efficiently manage product inventory and restocking.',TRUE, FALSE, '2022-08-02', '2022-11-30', 4, 4),
('Content Writing for Blog', 'Create high-quality content for our company blog to engage readers.', FALSE, FALSE, '2022-01-03', NULL, 5, 5),
('Customer Feedback Surveys', 'Design and conduct customer feedback surveys to gather insights for improvements.', TRUE, FALSE, '2022-02-04', '2022-12-15', 12, 12),
('Social Media Advertising', 'Launch social media advertising campaigns to increase our online reach.', TRUE, FALSE, '2022-03-05', NULL, 7, 7),
('Database Optimization', 'Optimize our database systems for faster data retrieval and storage.', FALSE, FALSE, '2022-04-06', '2022-11-30', 6, 6),
('Web Security Audit', 'Perform a comprehensive security audit of our website and systems.', FALSE, FALSE, '2022-05-07', NULL, 14, 14),
('Art Gallery Exhibition', 'Organize an art gallery exhibition to showcase local artists and their work.', TRUE, FALSE, '2022-06-08', '2022-12-31', 16, 16),
('Music Festival Planning', 'Plan and execute a music festival with multiple artists and stages.', TRUE, FALSE, '2022-07-09', NULL, 11, 11),
('Data Analytics Workshop', 'Host a workshop on data analytics to educate employees on data-driven decision-making.', TRUE, FALSE, '2022-09-10', '2022-11-30', 15, 15);

INSERT INTO project_users (project_id, user_id) VALUES
(1, 3),
(1, 8),
(2, 7),
(2, 17),
(2, 11),
(3, 8),
(3, 13),
(3, 2),
(4, 4),
(4, 5),
(5, 6),
(5, 15),
(6, 16),
(6, 12),
(7, 4),
(7, 9),
(8, 10),
(8, 13),
(9, 2),
(9, 5),
(10, 8),
(10, 14),
(11, 7),
(11, 12),
(12, 2),
(12, 3),
(13, 18),
(13, 19),
(14, 6),
(14, 16),
(15, 11),
(15, 15),
(16, 8),
(16, 13),
(17, 2),
(17, 9),
(18, 4),
(18, 5),
(19, 6),
(19, 16),
(20, 10),
(20, 12);


INSERT INTO task (title, description, priority, create_date, finish_date, state, create_by, assigned_to, project_task) VALUES
('Redesign Homepage Banner', 'Create a new homepage banner design for the website with a focus on our upcoming product launch.', 'High', '2022-10-17 08:00:00', '2022-10-18 16:00:00', 'assigned', 2, 3, 1),
('Keyword Research for Marketing', 'Conduct keyword research to _identify target keywords for our marketing campaign.', 'Medium', '2022-10-17 09:00:00', NULL, 'open', 3, NULL, 2),
('Product Launch Event Planning', 'Plan and coordinate the upcoming product launch event for our new offering.', 'High', '2022-10-19 10:00:00', '2022-10-24 16:00:00', 'assigned', 3, 17, 2),
('Customer Support Ticket System Upgrade', 'Upgrade our customer support ticket system to improve response times and user experience.', 'Low', '2022-10-17 10:00:00', '2022-10-19 14:00:00', 'assigned', 5, 8, 3),
('Sales Report Analysis', 'Analyze recent sales reports to _identify trends and opportunities for growth.', 'High', '2022-10-17 11:00:00', NULL, 'open', 7, NULL, 4),
('Mobile App UI Design', 'Design the user interface for the mobile app, focusing on a user-friendly experience.', 'Medium', '2022-10-17 12:00:00', '2022-10-20 12:00:00', 'assigned', 9, 6, 5), 
('Content Marketing Calendar Planning', 'Plan the content marketing calendar for the next quarter to align with our brand strategy.', 'Low', '2022-10-17 13:00:00', NULL, 'open', 11, NULL, 6),
('Software Testing and Quality Assurance', 'Conduct testing and quality assurance for a software product before release.', 'High', '2022-10-19 12:00:00', '2022-10-21 16:00:00', 'assigned', 11, 16, 6),
('Market Data Presentation', 'Prepare a presentation with insights from market data analysis for the executive team.', 'High', '2022-10-17 14:00:00', '2022-10-21 10:00:00', 'assigned', 13, 4, 7),
('Social Media Content Creation', 'Create engaging social media content to boost user engagement and brand visibility.', 'Medium', '2022-10-17 15:00:00', NULL, 'open', 15, NULL, 8),
('Project Management Tool Implementation', 'Implement a project management tool for efficient task tracking and coordination.', 'Low', '2022-10-17 16:00:00', '2022-10-22 18:00:00', 'assigned', 17, 2, 9),
('Blog Article Writing', 'Write a blog article on data analytics and its impact on business decision-making for the company blog.', 'High', '2022-10-17 17:00:00', NULL, 'open', 19, NULL, 10),
('Database Performance Monitoring', 'Monitor and optimize database performance to ensure efficient data retrieval.', 'Low', '2022-10-19 14:00:00', '2022-10-21 16:00:00', 'assigned', 19, 14, 10),
('E-commerce Platform Payment Integration', 'Integrate secure payment processing into the e-commerce platform.', 'High', '2022-10-18 08:00:00', '2022-10-20 16:00:00', 'assigned', 2, 7, 11),
('Inventory Management System Testing', 'Conduct testing of the product inventory management system to ensure accuracy.', 'Low', '2022-10-18 10:00:00', '2022-10-19 14:00:00', 'assigned', 4, 6, 12),
('Blog Article Proofreading', 'Proofread and edit blog articles to ensure high-quality content before publication.', 'Medium', '2022-10-18 11:00:00', '2022-10-21 16:00:00', 'assigned', 5, 19, 13),
('Customer Feedback Survey Analysis', 'Analyze data from customer feedback surveys to extract valuable insights.', 'High', '2022-10-18 12:00:00', '2022-10-22 16:00:00', 'assigned', 12, 16, 14),
('Social Media Ad Campaign Management', 'Manage and optimize social media advertising campaigns for better results.', 'Medium', '2022-10-18 13:00:00', '2022-10-25 16:00:00', 'assigned', 7, 11, 15),
('Database Query Optimization', 'Optimize database queries for faster data retrieval and reporting.', 'High', '2022-10-18 14:00:00', '2022-10-21 16:00:00', 'assigned', 6, 13, 16),
('Web Security Vulnerability Patching', 'Patch security vulnerabilities found during the web security audit.', 'Medium', '2022-10-18 15:00:00', '2022-10-20 14:00:00', 'assigned', 14, 9, 17),
('Art Gallery Exhibition Setup', 'Coordinate the setup and arrangement of artworks for the art gallery exhibition.', 'Low', '2022-10-18 16:00:00', NULL, 'open', 16, NULL, 18),
('Music Festival Ticket Sales', 'Manage and oversee ticket sales for the upcoming music festival.', 'Medium', '2022-10-18 17:00:00', '2022-10-23 14:00:00', 'archived', 11, 6, 19),
('Content Marketing Analysis', 'Analyze the performance of content marketing campaigns and prov_ide insights for improvement.', 'Medium', '2022-10-18 09:00:00', '2022-10-24 16:00:00', 'assigned', 15, 10, 20),
('Website Security Audit Report', 'Prepare a detailed security audit report for the website with findings and recommendations.', 'High', '2022-10-19 15:00:00', NULL, 'open', 15, NULL, 20);


INSERT INTO comment (content, create_date, edited, comment_by, task_comment) VALUES
('Great progress on this task!', '2022-10-17 08:30:00', FALSE, 8, 1),
('The new design looks fantastic!', '2022-10-17 14:15:00', FALSE, 7, 3),
('I need some more information to proceed.', '2022-10-17 16:30:00', FALSE, 13, 4),
('I am making good progress on this task.', '2022-10-18 12:45:00', FALSE, 15, 6), 
('Looking forward to seeing the content!', '2022-10-19 09:30:00', TRUE, 17, 8),
('Tool implementation is on track.', '2022-10-19 13:55:00', FALSE, 4, 9), 
('Keep up the good work!', '2022-10-20 14:25:00', FALSE, 5, 11),
('Let me know if you need assistance.', '2022-10-21 15:30:00', FALSE, 8, 13),
('Looking forward to the festival!', '2022-10-23 10:00:00', FALSE, 18, 16),
('The mobile app UI is looking great!', '2022-10-23 14:15:00', FALSE, 6, 17),
('We should analyze the sales trends further.', '2022-10-24 08:30:00', TRUE, 11, 18),
('Please make sure the content aligns with our brand.', '2022-10-24 12:45:00', FALSE, 13, 19);


INSERT INTO invite (title, description, create_date, invited_by, invited_to, project_invite) VALUES
('Web Development Collaboration', 'Join us in an exciting web development project to create innovative solutions.', '2022-10-21', 2, 5, 1),
('Marketing Campaign Team', 'Collaborate on a strategic marketing campaign to boost brand visibility and growth.', '2022-10-22', 9, 11, 5),
('Data Analysis Team Invitation', 'Join our team of data analysts to uncover valuable insights and drive informed decisions.', '2022-10-23', 13, 6, 7),
('Sales Optimization Initiative', 'Participate in an initiative to optimize our sales processes and increase revenue.', '2022-10-24', 2, 8, 11),
('E-commerce Platform Development', 'Get involved in the creation of an e-commerce platform for our online store.', '2022-10-25', 7, 10, 15),
('Content Marketing Collaboration', 'Collaborate on a content marketing strategy to enhance brand visibility and user engagement.', '2022-10-26', 16, 12, 18);


INSERT INTO message (content, create_date, edited, message_by, project_message) VALUES 
('Welcome to our project! We are excited to have you on board.', '2022-10-25', FALSE, 3, 1),
('Lets collaborate and make this project a success!', '2022-10-26', TRUE, 10, 8),
('Important update: We will have a team meeting tomorrow at 2 PM.', '2022-10-27', FALSE, 15, 5),
('Great job on completing your tasks ahead of schedule!', '2022-10-28', FALSE, 6, 14),
('Reminder: The project deadline is approaching. Keep up the good work!', '2022-10-29', FALSE, 9, 17);


-----------------------------------------
-- end
-----------------------------------------
```

---


## Revision history

Changes made to the second submission:
1. 03/10/2023 - EBD Created
2. 03/10/2023 - Added content to A4
3. 10/10/2023 - Finished A4 and started A5
4. 14/10/2023 - Finished A5
5. 17/10/2023 - Corrected errors in A4 and A5 and started A6
6. 22/10/2023 - Finished A6
7. 22/10/2023 - Fixed all the errors in all EBD

***

GROUP23117, 03/10/2023

* Inês Oliveira, up202103343@edu.fe.up.pt
* João Oliveira, up202108737@edu.fe.up.pt (editor)
* Pedro Magalhães, up202108756@edu.fe.up.pt
* Samuel Oliveira, up202108751@edu.fe.up.pt