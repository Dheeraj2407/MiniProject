/*
 ESP8266 --> ThingSpeak Channel
 
 This sketch sends the Wi-Fi Signal Strength (RSSI) of an ESP8266 to a ThingSpeak
 channel using the ThingSpeak API (https://www.mathworks.com/help/thingspeak).
 
 Requirements:
 
   * ESP8266 Wi-Fi Device
   * Arduino 1.8.8+ IDE
   * Additional Boards URL: http://arduino.esp8266.com/stable/package_esp8266com_index.json
   * Library: esp8266 by ESP8266 Community
   * Library: ThingSpeak by MathWorks
 
 ThingSpeak Setup:
 
   * Sign Up for New User Account - https://thingspeak.com/users/sign_up
   * Create a new Channel by selecting Channels, My Channels, and then New Channel
   * Enable one field
   * Enter SECRET_CH_ID in "secrets.h"
   * Enter SECRET_WRITE_APIKEY in "secrets.h"

 Setup Wi-Fi:
  * Enter SECRET_SSID in "secrets.h"
  * Enter SECRET_PASS in "secrets.h"
  
 Tutorial: http://nothans.com/measure-wi-fi-signal-levels-with-the-esp8266-and-thingspeak
   
 Created: Feb 1, 2017 by Hans Scharler (http://nothans.com)
*/

#include "ThingSpeak.h"
#include "secrets.h"
#include "DHT.h"        // including the library of DHT11 temperature and humidity sensor
#define DHTTYPE DHT11   // DHT 11

#define dht_dpin 0
DHT dht(dht_dpin, DHTTYPE);

unsigned long myChannelNumber = SECRET_CH_ID;
const char * myWriteAPIKey = SECRET_WRITE_APIKEY;

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

String EMAIL="email=immanuelebe30@gmail.com";
String FIELD ="&field=3";
String SERVER_NAME= "http://cvmaison.000webhostapp.com/read_field.php?"+EMAIL+FIELD;

char ssid[] = SECRET_SSID;   // your network SSID (name)
char pass[] = SECRET_PASS;   // your network password
int keyIndex = 0,counter=0;            // your network key index number (needed only for WEP)

WiFiClient  client;
HTTPClient http;
void setup() {
  Serial.begin(115200);
  delay(100);
  dht.begin();
  WiFi.mode(WIFI_STA);

  ThingSpeak.begin(client);
  pinMode(14,OUTPUT);
}

void loop() {

  // Connect or reconnect to WiFi
  if (WiFi.status() != WL_CONNECTED) {
    Serial.print("Attempting to connect to SSID: ");
    Serial.println(SECRET_SSID);
    while (WiFi.status() != WL_CONNECTED) {
      WiFi.begin(ssid, pass); // Connect to WPA/WPA2 network. Change this line if using open or WEP network
      Serial.print(".");
      delay(5000);
    }
    Serial.println("\nConnected.");
  }

  // Measure Signal Strength (RSSI) of Wi-Fi connection
  //long rssi = WiFi.RSSI();
    
  //Connect to server
  http.begin(SERVER_NAME);
  int httpCode=http.GET();
  
  //Fetching from server
  // httpCode will be negative on error. Success http code is 200
        if(httpCode > 0) {
            Serial.printf("[HTTP] GET... code: %d\n", httpCode);

            // receive response from the Server
            if(httpCode == HTTP_CODE_OK) {
                // On successful connection
                Serial.print("[HTTP] Received HTML...\n");
                String payload = http.getString();
                Serial.println(payload);
                if(payload.toInt()==0)
                  digitalWrite(14,LOW);
                else if(payload.toInt()==1)
                  digitalWrite(14,HIGH);
                 
                Serial.flush();
            }
        } else {
            Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
        }

        




  

  // Write value to Field 1 of a ThingSpeak Channel
  if(counter==0){
    float h = dht.readHumidity();
    int httpCode = ThingSpeak.writeField(myChannelNumber, 2, h, myWriteAPIKey);
    if (httpCode == 200) {
      Serial.println("Channel write successful humidity.");
      Serial.println(h);
    }
    else {
      Serial.println("Problem writing humidity to channel. HTTP error code " + String(httpCode));
    }
  }
  else if(counter==15){
    float t = dht.readTemperature();
    int httpCode = ThingSpeak.writeField(myChannelNumber, 1, t, myWriteAPIKey);
    if (httpCode == 200) {
      Serial.println("Channel write successful temperature.");
      Serial.println(t);
    }
    else {
      Serial.println("Problem writing temperature to channel. HTTP error code " + String(httpCode));
    }
  }
  // Wait 1 second to update the channel again
  counter++;
  if(counter>=30)
    counter=0;
  //client.
  delay(1000); 
}
