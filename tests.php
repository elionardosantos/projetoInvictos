<?php

// Sua string JSON
$jsonString = '{"updated":"2024-09-14T00:00:00.000Z","taxId":"45903253000103","alias":"Invictos","founded":"2022-04-04","head":true,"company":{"members":[{"since":"2022-04-04","person":{"id":"3307ec69-87b6-4379-8314-fd6bc6e66c62","type":"NATURAL","name":"Kihuane Rafael de Oliveira","taxId":"***166298**","age":"21-30"},"role":{"id":49,"text":"Sócio-Administrador"}}],"id":45903253,"name":"INVICTOS CONSULTORIA E NEGOCIACOES LTDA","equity":500000,"nature":{"id":2062,"text":"Sociedade Empresária Limitada"},"size":{"id":1,"acronym":"ME","text":"Microempresa"},"simples":{"optant":true,"since":"2022-04-04"},"simei":{"optant":false,"since":null}},"statusDate":"2022-04-04","status":{"id":2,"text":"Ativa"},"address":{"municipality":3550308,"street":"Avenida Ver Joao de Luca","number":"323","district":"Jardim Prudencia","city":"São Paulo","state":"SP","details":"Sala 01","zip":"04381000","country":{"id":76,"name":"Brasil"}},"mainActivity":{"id":7020400,"text":"Atividades de consultoria em gestão empresarial, exceto consultoria técnica específica"},"phones":[{"area":"11","number":"97383261"},{"area":"11","number":"73832613"}],"emails":[{"address":"invictosconsult@gmail.com","domain":"gmail.com"}],"sideActivities":[{"id":7490104,"text":"Atividades de intermediação e agenciamento de serviços e negócios em geral, exceto imobiliários"},{"id":8211300,"text":"Serviços combinados de escritório e apoio administrativo"}],"registrations":[],"suframa":[]}';

// Decodificando o JSON
$data = json_decode($jsonString);

// Extraindo a razão social
$razaoSocial = $data->company->name;

// Extraindo o endereço
$endereco = $data->address->street . ", " .
            $data->address->number . ", " .
            $data->address->district . ", " .
            $data->address->city . " - " .
            $data->address->state . ", " .
            $data->address->zip . ", " .
            $data->address->country->name;

// Exibindo os resultados
echo "Razão Social: " . $razaoSocial . "\n";
echo "Endereço: " . $endereco . "\n";

?>
