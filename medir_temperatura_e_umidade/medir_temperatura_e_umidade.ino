#include <WiFi.h>
#include <HTTPClient.h>
#include "DHT.h"

#define DHTPIN 4
#define DHTTYPE DHT11

const char* ssid = "moto g(20)";
const char* password = "123Gui321";
const char* serverName = "http://192.168.50.45/esp/esp/sensor.php";
DHT dht(DHTPIN, DHTTYPE);

void setup(){
  Serial.begin(115200);
  dht.begin();
  WiFi.begin(ssid, password);

  while(WiFi.status() != WL_CONNECTED){
    delay(1000);
    Serial.println("Conectando ao WiFi...");
  }
  Serial.println("Conectado ao WiFi");
}

void loop() {
  delay(1000);
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  Serial.print("Temperatura: ");
  Serial.println(t);
  Serial.print("Umidade: ");
  Serial.println(h);

  if (isnan(h) || isnan(t)){
    Serial.println("Falha ao ler do sensor DHT!");
    return;
  }

  HTTPClient http;
  http.begin(serverName);
  http.addHeader("Content-Type","application/x-www-form-urlencoded");
  String data = "temperature=" + String(t) + "&humidity" + String(h) + "&update=true";
  int httpResponseCode = http.POST(data);
  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
  String  response = http.getString();
  Serial.println("Resposta do servidor: " + response);
  http.end();
}
