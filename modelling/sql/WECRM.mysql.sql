CREATE TABLE Customer (
  ID      int(10) NOT NULL AUTO_INCREMENT, 
  Name    varchar(255), 
  Email   varchar(255), 
  Mobile  varchar(255), 
  AgentID int(10) NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Agent (
  ID       int(10) NOT NULL AUTO_INCREMENT, 
  Email    varchar(255), 
  Password varchar(255), 
  PRIMARY KEY (ID));
ALTER TABLE Customer ADD INDEX AgentCustomers (AgentID), ADD CONSTRAINT AgentCustomers FOREIGN KEY (AgentID) REFERENCES Agent (ID);
