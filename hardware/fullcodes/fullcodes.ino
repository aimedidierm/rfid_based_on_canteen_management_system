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

#define red 7
#define green 8
#define buzzer 6

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

byte rowPins[ROWS] = {A0,A1,A2,A3}; //connect to the row pinouts of the keypad
byte colPins[COLS] = {2,3,4}; //connect to the column pinouts of the keypad

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

int cstatus=0,balance=0;
String card;
void setup() 
{
  lcd.init();
  lcd.init();
  lcd.backlight();
  SPI.begin();  
  Serial.begin(115200);   // Initiate a serial communication
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522
  pinMode(red , OUTPUT);
  pinMode(green , OUTPUT);
  pinMode(buzzer , OUTPUT);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("SPS");
  lcd.setCursor(0,1);
  lcd.print("Student card");
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
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
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
  lcd.print("Enter money: ");
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
        lcd.print("*");
    }
    if (key=='#'&& j>0)
    {
    j=0;
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Loading");
    Serial.println((String)"?card='"+card+"'&money="+money+"'&pass="+pass);
    while(k==0){
      if (Serial.available() > 0) {
        //kwakira data zivuye kuri node mcu na server
      DynamicJsonBuffer jsonBuffer;
      JsonObject& root = jsonBuffer.parseObject(Serial.readStringUntil('\n'));
      if (root["cstatus"]) {
        cstatus=root["cstatus"];
      if(cstatus==1){
        balance=root["balance"];
        sussc();
      }
      if(cstatus==2){
        lowbalance();
      }
      if(cstatus==3){
        inpass();
      }
      
      }
      }
      }
    }
    delay(100);
    }
  }
void lowbalance(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Insufficient funds");
  digitalWrite(red,HIGH);
  tone(buzzer, 
  1000, 1000);
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
