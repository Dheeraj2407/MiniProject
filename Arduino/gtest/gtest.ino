#include <Adafruit_Sensor.h>

#include<stdlib.h>
#include "DHT.h"
//#include<ESP8266WiFi.h>
#define SSID "Dheeraj"//your network name
#define PASS "2C3C9D80"//your network password
#define IP "192.168.43.179" // thingspeak.com
#define DHTPIN 7     // what pin the DHT sensor is connected to
#define DHTTYPE DHT11   // Change to DHT22 if that's what you have
#define Baud_Rate 115200 //Another common value is 9600
#define GREEN_LED 3 //optional LED's for debugging
#define RED_LED 4 //optional LED's for debugging
#define DELAY_TIME 1000 //time in ms between posting data to ThingSpeak

//Can use a post also
String GET = "GET /MiniProject/functions1.php?Humidity=";
String FIELD2 = "&Temparature=";

//if you want to add more fields this is how
//String FIELD3 = "&field3=";

bool updated;

DHT dht(DHTPIN, DHTTYPE);

//this runs once
void setup()
{
  Serial.begin(Baud_Rate);
  Serial.println("AT");
  pinMode(12,OUTPUT);
  delay(5000);
  
  if(Serial.find("OK")){
    //connect to your wifi netowork
    bool connected = connectWiFi();
    if(!connected){
      //failure, need to check your values and try again
      Error();
    }
  }else{
    Error();
  }
  
  //initalize DHT sensor
  dht.begin();
}

//this runs over and over
void loop(){
  float h = dht.readHumidity();
  // Read temperature as Fahrenheit (isFahrenheit = true)
  float f = dht.readTemperature(true);

  // Check if any reads failed and exit early (to try again).
  if (isnan(h) || isnan(f)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }
 
  //update ThingSpeak channel with new values
  updated = updateTemp(String(f), String(h));
  //Serial.println(String(f)+" "+String(h));
  //wait for delay time before attempting to post again
  delay(DELAY_TIME);
}

bool updateTemp(String tenmpF, String humid){
  //initialize your AT command string
  String cmd = "AT+CIPSTART=\"TCP\",\"";
  
  //add IP address and port
  cmd += IP;
  cmd += "\",80";
  
  //connect
  Serial.println(cmd);
  delay(2000);
  if(Serial.find("Error")){
    return false;
  }
  
  //build GET command, ThingSpeak takes Post or Get commands for updates, I use a Get
  cmd = GET;
  cmd += tenmpF;
  cmd += FIELD2;
  cmd += humid;
  
  //continue to add data here if you have more fields such as a light sensor
  //cmd += FIELD3;
  //cmd += <field 3 value>
  
  cmd += "\r\n";
  
  //Use AT commands to send data
  Serial.print("AT+CIPSEND=");
  Serial.println(cmd.length());
  if(Serial.find(">")){
    //send through command to update values
    Serial.print(cmd);
    if(Serial.find("ON")){
      digitalWrite(12,HIGH);
    }
    else
     digitalWrite(12,LOW); 
  }else{
    Serial.println("AT+CIPCLOSE");
  }
  
  if(Serial.find("OK")){
    //success! Your most recent values should be online.
    return true;
  }else{
    return false;
  }
}
 
boolean connectWiFi(){
  //set ESP8266 mode with AT commands
  Serial.println("AT+CWMODE=1");
  delay(2000);
  Serial.println("AT+CIPSTA=\"192.168.43.197\"");
  delay(2000);
  //build connection command
  String cmd="AT+CWJAP=\"";
  cmd+=SSID;
  cmd+="\",\"";
  cmd+=PASS;
  cmd+="\"";
  
  //connect to WiFi network and wait 5 seconds
  Serial.println(cmd);
  delay(5000);
  
  //if connected return true, else false
  if(Serial.find("OK")){
    return true;
  }else{
    return false;
  }
}

void LightGreen(){
  digitalWrite(RED_LED, LOW);
  digitalWrite(GREEN_LED, HIGH);  
}

void LightRed(){
  digitalWrite(GREEN_LED, LOW);
  digitalWrite(RED_LED, HIGH);
}

//if an error has occurred alternate green and red leds
void Error(){      
  while(true){      
    LightRed();      
    delay(2000);      
    LightGreen();
    delay(2000);
  }
}