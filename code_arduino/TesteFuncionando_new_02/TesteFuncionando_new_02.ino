
#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>
#include <aJSON.h>
#include <LiquidCrystal.h>
#include <Keypad.h> 

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFF, 0xED };

char server[] = "192.168.1.2";
int port = 3128;
//char server[] = "sga.dfsolucoes.club";

const byte numRows=4; // Numero de linhas
const byte numCols=4; // Numero de colunas     

char keymap[numRows][numCols]= // Aqui é feito o "mapa" do teclado, que são as teclas
{
 {'1','2','3','A'},
 {'4','5','6','B'},
 {'7','8','9','C'},
 {'*','0','#','D'},
};

byte rowPins[numRows] = {22,24,26,28}; // Pinos digitais onde as linhas estão conectadas
byte colPins[numCols] = {30,32,34,36}; // Pinos digitais onde as colunas estão conectadas
 
Keypad myKeypad = Keypad(makeKeymap(keymap), rowPins, colPins, numRows, numCols);
 
IPAddress ip(192, 168, 1, 54);

EthernetClient client;

#define SS_PIN 53
#define RST_PIN 48

MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.
LiquidCrystal lcd(8, 9, 4, 5, 6,7);

//#define SS_PIN 10
//#define RST_PIN 9
//MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.



//Variaveis para a comunicação
String resposta ="";
String codigo = "10";
String laboratorio = "Lab02";
String tagAnterior = "";
String tagAutenticada = "";
bool emUso = false;
String passCard = "Aproxime o seu cartao do leitor...";

#define BIP 46
#define SAIDA_PORTA 42


void msgDisplay(String msg){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print(msg);
    Serial.println(msg);
}

void msgDisplayLine2(String msg){
    //lcd.clear();
    cleanLcd(1);
    lcd.setCursor(0,1);
    lcd.print(msg);
    Serial.println(msg);
}

void abrirPorta(){
  digitalWrite(SAIDA_PORTA, HIGH);
  delay(1000);
  digitalWrite(SAIDA_PORTA, LOW);
}

void msgPassCard(){
    msgDisplay("Aproxime o seu");
    msgDisplayLine2("cartao do leitor");
}

void bipFalha(){
    digitalWrite(BIP, HIGH);
    delay(100);
    digitalWrite(BIP, LOW);
    delay(50);
    digitalWrite(BIP, HIGH);
    delay(100);
    digitalWrite(BIP, LOW);
}

void abrirAposAutenticacao(){
  if(emUso){
      abrirPorta();
  }else{
      bipFalha();
  }  
}

void cleanLcd(int line){
  lcd.setCursor (0, line);
  for (int i = 0; i < 16; ++i)
  {
      lcd.write(' ');
  }
}


void getStatus(){
    
    String dados = "{\"environmentIdentification\":\""+laboratorio+"\"}";
    
    if (client.connect(server, port)) {
      msgDisplay("Obtendo status...");
      msgDisplayLine2("Aguarde!");
      client.println("POST http://sga.dfsolucoes.club/access-control/status HTTP/1.1");
      client.println("Host: sga.dfsolucoes.club");
      client.println("Content-Type:application/json");
      client.print("Content-Length: ");
      client.println(dados.length());
      client.println();
      client.println(dados);
      client.println("Connection: close");
      client.println();
      int capture = 0;
      do{
        if (client.available()) {
          char c = client.read();
          if(c == '{'){
            capture = 1;
          }
         
          if(capture ){
            String auxiliar (c);
            resposta = resposta + auxiliar;
            Serial.print(c);
            if (c == '}'){
              client.stop();
            }        
          }
        }
      }while(client.connected());
      // if the server's disconnected, stop the client:
    
      if (!client.connected()) {        
        client.stop();
        
        char buf[resposta.length()+10];
        resposta.toCharArray(buf, sizeof(buf));
        aJsonObject* jsonObject = aJson.parse(buf);
        
        emUso = aJson.getObjectItem(jsonObject,"success")->valuebool;
  
        if(emUso){
             tagAutenticada = aJson.getObjectItem(jsonObject,"identificationCard")->valuestring;
             msgDisplay(aJson.getObjectItem(jsonObject,"user")->valuestring);
        }else{
            msgPassCard();
        }
        
      }else{
        msgDisplay("Falha geral!");
      }
      resposta = "";
    }else{
       Serial.println("connection failed");
    }
    
    
}

void checkout(String identificador){
    String dados = "{\"environmentIdentification\":\""+laboratorio+"\",\"identificationCard\":\""+identificador+"\"}";
    if (client.connect(server, port)) {
      msgDisplay("Carregando...");
      client.println("POST http://sga.dfsolucoes.club/access-control/checkout HTTP/1.1");
      client.println("Host: sga.dfsolucoes.club");
      client.println("Content-Type:application/json");
      client.print("Content-Length: ");
      client.println(dados.length());
      client.println();
      client.println(dados);
      client.println("Connection: close");
      client.println();
      int capture = 0;
      do{
        if (client.available()) {
          char c = client.read();
          if(c == '{'){
            capture = 1;
          }
        
          if(capture ){
            String auxiliar (c);
            resposta = resposta + auxiliar;
            Serial.print(c);
            if (c == '}'){
           
              client.stop();
            }        
          }
        }
      }while(client.connected());
      // if the server's disconnected, stop the client:
    
      if (!client.connected()) {
        client.stop();
        char buf[resposta.length()+10];
        resposta.toCharArray(buf, sizeof(buf));
        aJsonObject* jsonObject = aJson.parse(buf);
        
        bool isSuccess = aJson.getObjectItem(jsonObject,"success")->valuebool;
  
        if(isSuccess){
            tagAutenticada = "";
            emUso = false;
            msgDisplay("Saida registrada!");
            delay(2000);
            msgPassCard();
        }else{
            bipFalha();
        }
        
      }else{
        msgDisplay("Falha geral!");
      }
      resposta = "";
    }else{
       Serial.println("connection failed");
    }
    tagAnterior = "";
}


String getSenha(){
     String senha = "";
     msgDisplay("Digite sua senha");
      do{
        char keypressed = myKeypad.getKey();
        if(keypressed !=  NO_KEY){
           if(keypressed == 'D'){
               return senha;
           }else if(keypressed == '#'){
               senha.remove(senha.length()-1);
           }else if(keypressed == 'C'){
               return "";
           }else{
               String auxiliar (keypressed);
               senha = senha + auxiliar; 
           }
           msgDisplayLine2(senha); 
        }  
      }while(1);
}

void autenticar(String identificador) {
 
    String senha = getSenha();

    bool successOperation = false;

    if(senha != ""){
        String dados = "{\"environmentIdentification\":\""+laboratorio+"\",\"identificationCard\":\""+identificador+"\",\"password\":\""+senha+"\"}";
       
        if (client.connect(server, port)) {
          msgDisplay("Autenticando...");
          client.println("POST http://sga.dfsolucoes.club/access-control/check HTTP/1.1");
          client.println("Host: sga.dfsolucoes.club");
          client.println("Content-Type:application/json");
          client.print("Content-Length: ");
          client.println(dados.length());
          client.println();
          client.println(dados);
          client.println("Connection: close");
          client.println();
          int capture = 0;
        
          do{
            if (client.available()) {
              char c = client.read();
              if(c == '{'){
                capture = 1;
              }
              
              if(capture){
                String auxiliar (c);
                resposta = resposta + auxiliar;
                Serial.print(c);
                if (c == '}'){
                  client.stop();
                }        
              }
             
            }
          }while(client.connected());
          // if the server's disconnected, stop the client:
        
          if (!client.connected()) {
            client.stop();
            char buf[resposta.length()+10];
            resposta.toCharArray(buf, sizeof(buf));
            aJsonObject* jsonObject = aJson.parse(buf);
            
            String c = aJson.getObjectItem(jsonObject,"c")->valuestring;
            
            if(c.equals("a5e2y6")){
              msgDisplay(aJson.getObjectItem(jsonObject,"p")->valuestring);
              successOperation = true;
              emUso = true;
              tagAutenticada = aJson.getObjectItem(jsonObject,"identificationCard")->valuestring;
              abrirPorta();
            }else{
              msgDisplay(aJson.getObjectItem(jsonObject,"p")->valuestring);
            }
          
          }else{
            msgDisplay("Falha geral!");
            tagAnterior = "";
            msgPassCard();
          }
          resposta = "";
        }else{
           Serial.println("connection failed");
        }
    }else{
        msgDisplay("Cancelado!");
      
    }

    if(!successOperation){
        delay(2000);
        msgPassCard();
        tagAnterior = "";
    }
}

void setup() {
  Serial.begin(9600);
  while (!Serial) {
  }

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
     Ethernet.begin(mac); 
     //Ethernet.begin(mac, ip);
  }
  lcd.begin(16, 2);
  SPI.begin();      // Inicia  SPI bus
  mfrc522.PCD_Init();   // Inicia MFRC522
  msgPassCard();
  pinMode(BIP, OUTPUT);
  pinMode(20, OUTPUT);

  getStatus();
} 
void loop() {

  char keypressed = myKeypad.getKey();
  if(keypressed !=  NO_KEY){
      if(keypressed == 'A'){
          abrirAposAutenticacao();
      }
  }
    
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()){
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  String conteudo= "";
  byte letra;
  
  for (byte i = 0; i < mfrc522.uid.size; i++) {
     conteudo.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
     conteudo.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  
  conteudo.toUpperCase();

  Serial.println(conteudo.substring(1));
  Serial.println(tagAutenticada);

  if(tagAutenticada == conteudo.substring(1)){
     checkout(conteudo.substring(1));
  }
  else if(conteudo != "" && !emUso){
    digitalWrite(BIP, HIGH);
    delay(500);
    digitalWrite(BIP, LOW);
    tagAnterior = conteudo;
    autenticar(conteudo.substring(1));
  }else if(conteudo != ""){
    msgDisplay("Press A p/ abrir!");
    delay(2000);
    getStatus(); 
  }
}
  
