#include <ArduinoJson.h>
#include <SPI.h>
#include <MFRC522.h>
#include <Wire.h>
#include <Keypad.h>
#include <LiquidCrystal_I2C.h>
#define SS_PIN 10
#define RST_PIN 9
MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.
LiquidCrystal_I2C lcd(0x27,20,4);  // set the LCD address to 0x27 for a 16 chars and 2 line display

#define red 6
#define green 5
#define buzzer 8

const byte ROWS = 4; //four rows
const byte COLS = 4; //four columns
//define the cymbols on the buttons of the keypads
char newNum[12]="",money[12]="",pass[12]="";
//define the cymbols on the buttons of the keypads
char keys[ROWS][COLS] = {

    {'1','2','3'},

    {'4','5','6'},

    {'7','8','9'},

    {'*','0','#'}

};

byte rowPins[ROWS] = {7,3,4,2}; //connect to the row pinouts of the keypad
// byte colPins[COLS] = {A0,A1,A2,A3}; //connect to the column pinouts of the keypad
byte colPins[COLS] = {A0,A1,A2}; //connect to the column pinouts of the keypad

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

int cstatus=0,balance=0;
String card;
String data = "";

void setup() 
{
  lcd.init();
  lcd.init();
  lcd.backlight();
  SPI.begin();  
  Serial.begin(9600);   // Initiate a serial communication
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522
  pinMode(red , OUTPUT);
  pinMode(green , OUTPUT);
  pinMode(buzzer , OUTPUT);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("RFID based on");
  lcd.setCursor(0,1);
  lcd.print("canteen MS");
  delay(3000);
}

void loop() 
{
  readcard();
}

  
void(* resetFunc) (void) = 0;

void readcard(){
  // Look for new cards
  int i=0,j=0,m=0,x=0,s=0,money=0;
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Tap your card");
  delay(500);
  if ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    readcard();
    //return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    readcard();
    //return;
  }
  String content= "";
  byte letter;
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : ""));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  content.toUpperCase();
  card=content.substring(1);
  entermoney();
  delay(100);
  }
void entermoney(){
  int j=0,k=0;
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Enter code: ");
  for( int d=2; d>1;d++){
    int key = keypad.getKey();
    if (key!=NO_KEY && key!='#' && key!='*'){
        money[j] = key;
        money[j+1]='\0';   
        j++;
        lcd.setCursor(0, 1);
        lcd.print(money);
    }
    if (key=='#'&& j>0)
    {
      enterpass();
    }
    delay(100);
    }
  }
void enterpass(){
  int j=0,k=0;
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Enter password:");
  for( int d=2; d>1;d++){
    int key = keypad.getKey();
    if (key!=NO_KEY && key!='#' && key!='*'){
        pass[j] = key;
        pass[j+1]='\0';   
        j++;
        lcd.setCursor(0,1);
        lcd.print("**********");
    }
    if (key=='#'&& j>0)
    {
      j=0;
      lcd.clear();
      lcd.setCursor(0,0);
      lcd.print("Loading");
      // Serial.println((String)"{'card':'" + card + "', '" + "code':" + money + ", " + "'pass':'" + pass + "'}");
      String request = card + "," + money + "," + pass + "\n";
      Serial.print(request);
      delay(1000);
      processTransaction();
    }
    delay(100);
    }
  }

void processTransaction() {
  bool transactionCompleted = false;

  StaticJsonDocument<512> doc;  

  while (!transactionCompleted) {
    if (Serial.available() > 0) {
      data = Serial.readStringUntil('\n');
      Serial.println(data);
      delay(100);
      doc.clear();

      DeserializationError error = deserializeJson(doc, data);
      delay(100);

      if (error) {
        Serial.print(F("deserializeJson() failed: "));
        Serial.println(error.f_str());
        return;
      }

      if (doc["c"]) {
        cstatus=doc["c"];
        if(cstatus==4){
          balance=doc["b"];
          sussc();
        }
        if(cstatus==2){
          lowbalance();
        }
        if(cstatus==3){
          inpass();
        }      
        if(cstatus==5){
          codenot();
        }
        if(cstatus==6){
          nouser();
        }
        transactionCompleted = true;
      }
    }

    delay(100);
  }
}
void lowbalance(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Low balance");
  digitalWrite(red,HIGH);
  tone(buzzer,1000, 1000);
  delay(3000);
  digitalWrite(red,LOW);
  resetFunc();
}
void inpass() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Incorect password");
  digitalWrite(red,HIGH);
  tone(buzzer, 700, 1000);
  delay(3000);
  digitalWrite(red,LOW);
  resetFunc();
}
void codenot(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Code not valid");
  digitalWrite(red,HIGH);
  tone(buzzer, 700, 1000);
  delay(3000);
  digitalWrite(red,LOW);
  resetFunc();
  }
void nouser(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Card not found");
  digitalWrite(red,HIGH);
  tone(buzzer, 700, 1000);
  delay(3000);
  digitalWrite(red,LOW);
  resetFunc();
  }
void sussc(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Thank you");
  lcd.setCursor(0, 1);
  lcd.print("Balance:");
  lcd.print(balance);
  digitalWrite(green,HIGH);
  tone(buzzer, 500, 1000);
  delay(3000);
  digitalWrite(green,LOW);
  resetFunc();
  }
