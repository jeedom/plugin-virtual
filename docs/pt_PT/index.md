# Plugin virtual

O plugin **Virtual** permite a criação de equipamentos virtuais e controles virtuais.

Nesta documentação, nomearemos um dispositivo criado por este plugin como um **equipamento virtual**.

O equipamento virtual pode ser útil para as seguintes necessidades :

- consolidar em um único dispositivo as informações e / ou ações de diversos dispositivos físicos / virtuais,
- criar equipamentos alimentados por uma fonte externa à Jeedom *(Zibase, IPX800, etc)*,
- duplicar o equipamento para dividi-lo em 2, por exemplo,
- realizar um cálculo em vários valores de equipamento,
- realizar várias ações *(macro)*.

>**IMPORTANTE**
>
>Os virtuais não devem ser abusados porque levam ao consumo excessivo geral *(cpu / memória / troca / disco)*, tempos de latência mais longos, desgaste do cartão SD, etc ! Virtuais são ferramentas para serem usadas com moderação apenas quando necessário.

# Configuration

## Configuração de plug-in

Este plugin não requer nenhuma configuração especial e deve simplesmente ser ativado após a instalação.

## Criar/atualizar monitor Jeedom

Botão que permite criar equipamentos de internet Jeedom que fornecerão informações internas sobre Jeedom : 

- para cada plugin que possui um daemon, um comando sobre o estado do daemon
- para cada plugin que possui um daemon, um comando para iniciar o daemon
- para cada plugin que tenha um daemon, um comando para parar o daemon
- número de atualizações disponíveis
- número de mensagens no centro de mensagens
- versão do Jeedom
- faça um backup
- lançar a atualização do Jeedom (e plugins)


## Configuração do equipamento

Dispositivos virtuais são acessíveis a partir do menu **Plugins → Programação → Virtual**.

Clique em um dispositivo virtual para acessar sua página de configuração :

- **Nome virtual** : nome do seu equipamento virtual.
- **Objeto pai** : indica o objeto pai ao qual o equipamento pertence,
- **Categoria** : categorias de equipamentos *(pode pertencer a várias categorias)*,
- **Ativar** : permite tornar o equipamento ativo,
- **Visivél** : permite tornar o equipamento visível no painel.
- **Auto atualização** : Frequência de atualização dos comandos de informação *(por cron - um assistente está disponível clicando no ponto de interrogação no final da linha)*.
- **URL de retorno** : é possível alterar o valor de uma informação virtual por API (``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#Eplugin=virtualEtype=eventEid=#CMD_ID#Evalue=#VALUE#``)
- **Descrição virtual** : permite que você descreva o equipamento virtual.

>**TRUQUE**
>
>A respeito de mim'**URL de retorno**, certifique-se de adicionar ``/jeedom`` depois de ``#IP_JEEDOM#`` se necessário.

No canto superior direito você tem acesso a 3 botões além daqueles comuns a todos os plug-ins :

- **Expressão** : abre o testador de expressão para facilitar a implementação de alguns virtuais.
- **Modelo** : permite que você crie um dispositivo virtual muito rapidamente selecionando um modelo.
- **Equipamento de importação** : Duplica automaticamente o equipamento existente como equipamento virtual *(para economizar tempo a fim de dividir um equipamento em 2, por exemplo)*.

# Commandes

Ao clicar na guia **Pedidos**, você encontrará a lista de controles virtuais :

- **EU IRIA** : o número de identificação do pedido.
- **Nome** :
    - **Nome do pedido** : o nome exibido no painel.
    - **Ícone** : se aplicável, o ícone que representa o pedido.
    - **Comando de informações relacionadas** *(actions)* : usado para inserir o comando de informações de status vinculado ao comando de ação.
- **Modelo** : tipo e subtipo,
- **Valor** : permite dar o valor do comando de acordo com outro comando, uma chave *(quando fazemos uma troca virtual)*, um cálculo, etc...
- **Definições** :
    - **Valor de retorno de status** E **Duração antes do retorno do status** *(infos)* : permite que você indique que o valor deve retornar a ``Y``, ``X minutes`` depois de uma mudança. Por exemplo, no caso de um detector de movimento que emite apenas após a detecção, é útil colocar ``0`` em valor e ``4`` em duração de modo que 4 minutos após uma detecção de movimento, o valor do comando reverta para ``0`` *(se não houve outras detecções desde)*.
    - **Informação para atualizar** E **valor da informação** *(actions)* : permite-lhe indicar um comando info para actualizar durante a execução do comando e o valor a atribuir a ele.
- **Opções** :
  - **Display** : permite que você exiba o pedido no painel.
  - **Historicizar** : permite registrar o pedido.
  - **Reverter**: permite inverter o valor do comando *(info / binário apenas)*.
  - **Min / max** : limites de valor de comando *(pode estar vazio - min:0/max:100 por padrão)*.
  - **Unidade** : unidade de valor do pedido *(pode estar vazio)*.
  - **Lista de valores** : Lista de ``valeur|texte`` separados por um ``; (point-virgule)`` *(ação / lista apenas)*.
- **Ações** :
    - **Configuração avançada** *(rodas dentadas)* : usado para exibir a configuração avançada do comando *(método de historização, widget, etc...)*.
    - **Teste** : permite testar o comando.
    - **Deletar** *(sinal -)* : permite excluir o comando.

>**EM FORMAÇÃO**
>
>Cada dispositivo virtual tem um comando **Atualizar** que permite forçar a atualização de todos os comandos de informação.

# Exemplos virtuais

## Comutador virtual

Para fazer uma troca virtual, você deve adicionar 2 ações virtuais como esta :

![virtual5](../images/virtual5.png)

Então você salva e o Jeedom adiciona automaticamente o comando de informações virtuais :

![virtual6](../images/virtual6.png)

Adicionar à ação "pedidos"" ``On`` e ``Off``, A ordem ``Etat`` (isso permite que o Jeedom faça o link com o comando state).

Para ter um widget legal, você deve ocultar o comando de status :

![virtual7](../images/virtual7.png)

Atribua um widget que gerencia o feedback de status aos 2 comandos de ação, por exemplo, aqui o widget leve. Para fazer isso, clique na pequena roda dentada na frente do controle ``On`` e na 2ª guia, selecione ``light`` como widget :

![virtual8](../images/virtual8.png)

Salve e faça o mesmo para o pedido ``Off``. E você terá um bom widget que mudará de estado quando clicado :

![virtual9](../images/virtual9.png)

## Controle deslizante virtual

Para fazer um controle deslizante virtual, você deve adicionar uma ação virtual como esta :

![virtual12](../images/virtual12.png)

Como antes após o backup, o Jeedom criará automaticamente o comando info :

![virtual13](../images/virtual13.png)

E, como antes, é aconselhável vincular a ação ao comando status e ocultá-la.

## Interruptor de alavanca

É assim que se faz uma chave de alternância (ou botão de pressão), para isso você deve criar uma ação virtual deste tipo :

![virtual14](../images/virtual14.png)

Em seguida, salve para ver o comando status aparecer :

![virtual15](../images/virtual15.png)

Aqui é necessário no valor do comando action colocar ``not(#[...][...][Etat]#)`` *(substitua por seu próprio pedido)* e vincular o estado ao comando de ação (tenha cuidado, você não deve ocultar o comando de estado desta vez). Você também deve colocar o comando info no subtipo binário.

## Pedidos múltiplos

Para fazer um cálculo em vários pedidos, é muito fácil ! Basta criar um comando virtual do tipo ``info/Numérique`` e no campo valor coloque seus cálculos. O testador de expressão pode ajudá-lo com esta etapa para validar. Por exemplo, para média de 2 temperaturas :

![virtual10](../images/virtual10.png)

Vários pontos a serem feitos corretamente :

- Escolha o subtipo de acordo com o tipo de informação (aqui cálculo da média para que seja um numérico),
- Coloque parênteses nos cálculos, para ter certeza do resultado da operação,
- Coloque a unidade bem,
- Marque a caixa para registrar, se necessário.

Veremos aqui como fazer um pedido que desligará 2 luzes. Nada poderia ser mais simples, basta criar um comando virtual do tipo ``action/Défaut`` e coloque os 2 comandos separados por um ``EE`` :

![virtual11](../images/virtual11.png)

É imperativo que o subtipo do comando seja igual aos subtipos dos comandos controlados. Todos os comandos no campo de valor devem, portanto, ter o mesmo subtipo *(todos os "outros" ou todos os "controles deslizantes" ou todos do tipo "cor", etc...)*.

## Feedback do status virtual

Ao usar equipamentos que não possuem feedback de status e se este equipamento é controlado apenas pela Jeedom, é possível ter um feedback de status virtual. Isso requer a criação de um virtual que execute os comandos de ações (ex: On & Off) do equipamento e que possui um comando info (o). Em seguida, você deve preencher a coluna Parâmetro para cada comando de ação, selecionando o nome do comando info (status) e fornecendo o valor que ele deve assumir.

Também podemos imaginar um virtual que liga / desliga várias lâmpadas (comandos de ações separados por &&) e, portanto, tem um status desse comando geral.
