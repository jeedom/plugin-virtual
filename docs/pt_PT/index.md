# Plugin virtual

O plug-in virtual permite a criação de dispositivos virtuais e suas propriedades.

Vamos nomear um dispositivo criado por este plugin : dispositivo virtual.

Um dispositivo virtual pode ser criado para as seguintes necessidades :

-   consolidar informações ou ações de vários dispositivos físicos / virtuais em um único dispositivo;
-   crie um periférico alimentado por uma fonte externa ao Jeedom (Zibase, IPX800, etc.);
-   equipamento duplicado para dividi-lo em 2, por exemplo;
-   realizar um cálculo em vários valores de equipamento;
-   executar várias ações (macro).

# Configuration

O plugin não requer nenhuma configuração, você apenas precisa ativá-lo :

![virtual1](../images/virtual1.png)

# Configuração do equipamento

A configuração de dispositivos virtuais pode ser acessada no menu do plug-in :

![virtual2](../images/virtual2.png)

É assim que a página do plugin virtual se parece (aqui já com um equipamento) :

![virtual3](../images/virtual3.png)

É assim que a página de configuração de um dispositivo virtual se parece :

![virtual4](../images/virtual4.png)

> **Dica**
>
> Como em muitos lugares do Jeedom, colocar o mouse na extremidade esquerda permite que um menu de acesso rápido seja exibido (você sempre pode deixá-lo visível em seu perfil).

Aqui você encontra toda a configuração do seu equipamento :

-   **Nome do dispositivo virtual** : nome do seu equipamento virtual,
-   **Objeto pai** : indica o objeto pai ao qual o equipamento pertence,
-   **Categoria** : categorias de equipamentos (pode pertencer a várias categorias),
-   **Ativar** : torna seu equipamento ativo,
-   **Visivél** : torna visível no painel,
-   **COMMENTAIRE** : permite comentar sobre o equipamento.

No canto superior direito, você tem acesso a 4 botões :

-   **Expressão** : o testador de expressão idêntico ao dos cenários para facilitar o desenvolvimento de algumas configurações virtuais
-   **Equipamento de importação** : permite duplicar automaticamente um equipamento existente em um virtual (economiza tempo para dividir um equipamento em 2, por exemplo),
-   **Duplicar** : duplica o equipamento atual,
-   **Avançado (rodas dentadas)** : exibe opções avançadas de equipamento (comuns a todos os plugins Jeedom).

Abaixo você encontra a lista de pedidos :

-   o nome exibido no painel,
-   tipo e subtipo,
-   o valor : permite dar o valor do comando de acordo com outro comando, uma chave (quando fazemos uma troca virtual), um cálculo, etc.
-   "Valor do feedback do status "e" Duração antes do feedback do status" : permite indicar a Jeedom que após uma alteração nas informações, seu valor deve retornar a Y, X min após a alteração. Exemplo : no caso de um detector de presença que emite apenas durante uma detecção de presença, é útil definir, por exemplo, 0 em valor e 4 em duração, de modo que 4 minutos após a detecção de movimento (e s ' não houve notícias desde então) Jeedom redefine o valor das informações para 0 (mais movimento detectado),
-   Unidade : unidade de dados (pode estar vazia),
-   Historicizar : permite historiar os dados,
-   Display : permite exibir os dados no painel,
-   Evento : no caso do RFXcom, essa caixa sempre deve ser marcada, porque você não pode interrogar um módulo do RFXcom,
-   min / max : limites de dados (podem estar vazios),
-   configuração avançada (pequenas rodas dentadas) : exibe a configuração avançada do comando (método de registro, widget etc.),
-   "Tester" : permite testar o comando,
-   excluir (assinar -) : permite excluir o comando.

# Tutoriel

## Comutador virtual

Para fazer um comutador virtual, você precisa adicionar 2 comandos virtuais como este :

![virtual5](../images/virtual5.png)

Então você salva e o Jeedom adiciona automaticamente o comando de informações virtuais :

![virtual6](../images/virtual6.png)

Adicionar à ação "pedidos"" ``On`` e ``Off``, A ordem ``Etat`` (isso permite que o Jeedom faça o link com o comando state).

Para ter um bom widget, você precisa ocultar o comando status :

![virtual7](../images/virtual7.png)

Atribua um widget que gerencia o feedback de status aos 2 comandos de ação, por exemplo, aqui o widget leve. Para fazer isso, clique na pequena roda dentada na frente do controle ``On`` e na 2ª guia, selecione ``light`` como widget :

![virtual8](../images/virtual8.png)

Salve e faça o mesmo para o pedido ``Off``. E você terá um bom widget que mudará de estado quando clicado :

![virtual9](../images/virtual9.png)

## Controle deslizante virtual

Para criar um controle deslizante virtual, adicione um comando virtual como este :

![virtual12](../images/virtual12.png)

Como antes após o backup, o Jeedom criará automaticamente o comando info :

![virtual13](../images/virtual13.png)

E, como antes, é aconselhável vincular a ação ao comando status e ocultá-la.

## Interruptor de alavanca

É assim que se alterna o tipo, para isso é necessário criar um comando virtual desse tipo :

![virtual14](../images/virtual14.png)

Em seguida, salve para ver o comando status aparecer :

![virtual15](../images/virtual15.png)

Aqui é necessário no valor do comando action colocar ``not(\#[...][...][Etat]#)`` (substitua por seu próprio comando) e vincule o estado ao comando action (tenha cuidado, você não deve ocultar o comando state desta vez). Você também deve colocar o comando info no subtipo binário.

Para fazer um cálculo em vários pedidos, é muito fácil ! Basta criar uma ordem do tipo de informação virtual e, no campo valor, colocar seus cálculos. O testador de expressão pode ajudá-lo com esta etapa para validar. Por exemplo, para média de 2 temperaturas :

![virtual10](../images/virtual10.png)

Vários pontos a serem feitos corretamente :

-   Escolha o subtipo de acordo com o tipo de informação (aqui a média é um número),
-   Coloque parênteses nos cálculos, para ter certeza do resultado da operação,
-   Coloque a unidade bem,
-   Marque a caixa para registrar, se necessário,



## Pedidos múltiplos


Veremos aqui como fazer um pedido que desligará 2 luzes. Nada poderia ser mais simples, basta criar um pedido virtual e colocar os 2 pedidos separados por um ``&&`` :

![virtual11](../images/virtual11.png)

Aqui, o subtipo de comando deve ser o mesmo que os subtipos de comando controlado; portanto, todos os comandos no campo de valor devem ter o mesmo subtipo (controle deslizante "todos os outros" ou todos " "ou todas as cores).

## Feedback do status virtual

Ao usar equipamentos que não possuem feedback de status e se este equipamento é controlado apenas pela Jeedom, é possível ter um feedback de status virtual. Isso requer a criação de um virtual que execute os comandos de ações (ex: On & Off) do equipamento e que possui um comando info (o status). Em seguida, você deve preencher a coluna Parâmetro para cada comando de ação, selecionando o nome do comando info (status) e fornecendo o valor que ele deve assumir.

Também podemos imaginar um virtual que liga / desliga várias lâmpadas (comandos de ações separados por &&) e, portanto, tem um status desse comando geral.

# Atribuindo um valor pela API

É possível alterar o valor da informação virtual por um
Chamada de API :

``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#``

> **NOTA**
>
> Tenha cuidado para adicionar um / jeedom após \#IP\_JEEDOM\# se necessário
