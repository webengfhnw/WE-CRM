CREATE TABLE Customer (
  ID      SERIAL NOT NULL, 
  Name    varchar(255), 
  Email   varchar(255), 
  Mobile  varchar(255), 
  AgentID int4 NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Agent (
  ID       SERIAL NOT NULL, 
  Name     varchar(255), 
  Email    varchar(255), 
  Password varchar(255), 
  PRIMARY KEY (ID));
ALTER TABLE Customer ADD CONSTRAINT AgentCustomer FOREIGN KEY (AgentID) REFERENCES Agent (ID);
