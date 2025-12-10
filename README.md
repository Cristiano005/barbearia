<h1 align="center">Barbershop</h1>

<p align="center">
  Um projeto completo de barbearia, com foco em demonstrar habilidades em front e back-end.
</p>

<p align="center">
  <a href="#technologies">Tecnologias</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#project">Projeto</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#guidelines">Orientações</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#challenges">Desafios</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#extras">Extras</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#memo-licença">Licença</a>
</p>

<p align="center">
  <img alt="License" src="https://img.shields.io/static/v1?label=license&message=MIT&color=49AA26&labelColor=000000">
</p>

<br>

<p align="center">
  <img alt="Demonstração do Projeto" src=".github/assets/barbershop.png" width="100%">
</p>

<h2> 🚀 Tecnologias </h2>

<p id="technologies">Este projeto foi desenvolvido com:</p>

<h3> Frontend </h3>

    🎨 Vue.js 3 — framework reativo para construção da interface

    🟦 TypeScript — tipagem estática e maior segurança no código

    🧪 VeeValidate + Yup — validação de formulários e schemas

    📅 Vue DatePicker (@vuepic/vue-datepicker) — seleção personalizada de datas

    🧩 Axios — comunicação entre frontend e API

    🎛️ Bootstrap 5 — estilização, layout responsivo e componentes UI

<h3> Backend </h3>

    🐘 Laravel — estrutura robusta para API REST

    🗄️ MySQL — banco de dados relacional

<h3> Infraestrutura / DevOps </h3>

    🐳 Docker & Docker Compose — containerização do ambiente completo

    📦 Composer / NPM — gerenciamento de dependências backend e frontend

<h3> Outras Ferramentas </h3>

    🍬 SweetAlert2 — alertas e feedbacks visuais

    📏 Yup — validações complexas baseadas em schema

## 💻 Projeto

<p id="project"> Este projeto é um sistema completo de agendamento para barbearias, desenvolvido para facilitar tanto a experiência do cliente quanto o gerenciamento do barbeiro. </p>

Os usuários podem criar, visualizar e editar seus agendamentos de forma simples e intuitiva. O sistema conta também com um painel administrativo destinado ao barbeiro, onde é possível:

    📅 Cadastrar e gerenciar horários disponíveis

    💈 Criar, editar e remover serviços oferecidos

    👤 Visualizar todos os agendamentos registrados

    📊 Acessar um dashboard com métricas importantes, como faturamento e quantidade de atendimentos

    ⚙️ Controlar a agenda de forma organizada e eficiente

  O objetivo principal do projeto é oferecer uma solução moderna, responsiva e fácil de utilizar, conectando clientes ao serviço de barbearia com praticidade e controle total.

## 🗺️ Orientações

<p id="guidelines"> Antes de começar, certifique-se de ter o Docker instalado na sua máquina. Todo o restante — PHP, Composer, Node, NPM e MySQL — já está dentro dos containers. </p>

1 - Na pasta barbershop-api, abra-a, renomei o arquivo ".env.example" para ".env", garantindo que as variáveis de ambiente sejam localizadas.

2 - No mesmo arquivo, preencha as variavéis de ambiente de banco de dados para prosseguir:

    DB_CONNECTION=mysql
    DB_HOST=barbershop-mysql
    DB_PORT=3306
    DB_DATABASE=barbershop_api
    DB_USERNAME=
    DB_PASSWORD=

3 - Abra o projeto na pasta barbershop/.
No terminal, execute:
    
    docker compose up

Este comando irá subir todo o ambiente já com todas as dependências instaladas automaticamente pelos containers.

4 - Após toda a preparação do ambiente, é hora de gerar o "app key" da API, da aplicação Laravel. Para isso entre no container da API:
        
    docker exec -it barbershop-api bash

Logo após, execute o seguinte comando:
        
    php artisan key:generate

5 - Dentro do próprio container da API, rode o seguinte comando para executar as migrations para criar as tabelas e também para popular as mesmas com dados para testes.

    php artisan migrate --seed


## ⚔️ Desafios enfrentados

<p id="challenges">

Durante o desenvolvimento, enfrentei desafios relacionados tanto ao ambiente quanto à lógica do projeto. Trabalhar com várias ferramentas em conjunto exigiu bastante atenção para entender como tudo se integra. A configuração do Docker e a organização do ambiente de desenvolvimento foram etapas que demandaram tempo e cuidado.

Outro desafio constante foi lidar com a complexidade do código ao combinar Vue 3, TypeScript e VeeValidate, especialmente em cenários de validação, manipulação de datas e atualização dinâmica de componentes. A lógica de negócio também apresentou situações desafiadoras, que exigiram repensar abordagens, revisar fluxos e aprimorar decisões técnicas.

Apesar disso, cada obstáculo contribuiu para um aprendizado sólido e uma evolução significativa no domínio dessas ferramentas.

</p>

## ➕ Extras

<p id="extras"> Fique à vontade para explorar ou se inspirar. </p>