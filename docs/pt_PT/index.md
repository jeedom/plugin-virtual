# 1. Introdução

O plug-in virtual permite a criação de dispositivos virtuais
e suas propriedades.

Vamos nomear um dispositivo criado por este plugin : periférico
virtuel.

Um dispositivo virtual pode ser criado para as seguintes necessidades :

-   consolide informações ou ações de um único dispositivo
    vários dispositivos físicos / virtuais;

-   criar um dispositivo alimentado por uma fonte externa ao Jeedom
    (Zibase, IPX800 ...);

-   equipamento duplicado para dividi-lo em 2, por exemplo;

-   realizar um cálculo em vários valores de equipamento;

-   executar várias ações (macro).




# Configuration

O plugin não requer nenhuma configuração, você apenas precisa ativá-lo :

![virtual1](../images/virtual1.png)




# Configuração do equipamento

A configuração dos dispositivos virtuais é acessível a partir do
menu de plugins :

![virtual2](../images/virtual2.png)

É assim que a página do plug-in virtual se parece (aqui, já com um
equipamento) :

![virtual3](../images/virtual3.png)

É assim que a página de configuração de um dispositivo virtual se parece
:

![virtual4](../images/virtual4.png)

> **Tip**
>
> Como em muitos lugares em Jeedom, coloque o mouse na extremidade esquerda
> abre um menu de acesso rápido (você pode
> do seu perfil, deixe-o sempre visível).

Aqui você encontra toda a configuração do seu equipamento :

-   **Nome do dispositivo virtual** : nome do seu equipamento virtual,

-   **Objeto pai** : indica o objeto pai ao qual pertence
    o equipamento,

-   **Categoria** : categorias de equipamentos (pode pertencer a
    várias categorias),

-   **Activer** : torna seu equipamento ativo,

-   **Visible** : torna visível no painel,

-   **Commentaire** : permite que você comente
    o equipamento.

No canto superior direito, você tem acesso a 4 botões :

-   **Expression** : o testador de expressão idêntico ao dos cenários
    para facilitar o desenvolvimento de algumas

-   **Equipamento de importação** : permite duplicar automaticamente um
    equipamento existente em um ambiente virtual (economiza tempo para
    equipamento dividido em 2, por exemplo),

-   **Dupliquer** : duplica o equipamento atual,

-   **Avançado (rodas dentadas)** : exibe opções
    avanços do equipamento (comuns a todos os plugins Jeedom).

Abaixo você encontra a lista de pedidos :

-   o nome exibido no painel,

-   tipo e subtipo,

-   o valor : permite dar o valor do pedido de acordo
    outro comando, uma chave (quando você faz uma troca
    ), um cálculo etc..

-   "Valor do feedback do status "e" Duração antes do feedback do status" : permet
    para indicar a Jeedom que após uma alteração nas informações
    O valor deve retornar para Y, X min após a alteração. Exemplo : dans
    no caso de um detector de presença que emite apenas durante um
    detecção de presença, é útil definir, por exemplo, 0
    valor e 4 de duração, de modo que 4 minutos após a detecção de movimento
    (e se não houver notícias desde então) Jeedom retira o
    valor da informação em 0 (não é mais detectado movimento),

-   Unidade : unidade de dados (pode estar vazia),

-   Historicizar : permite historiar os dados,

-   Display : permite exibir os dados no painel,

-   Evento : no caso da RFXcom, essa caixa deve sempre ser
    verificado porque você não pode consultar um módulo RFXcom,

-   min / max : limites de dados (podem estar vazios),

-   configuração avançada (pequenas rodas dentadas) : permite exibir
    configuração avançada do comando (método de historização,
    widget etc.),

-   "Tester" : permite testar o comando,

-   excluir (assinar -) : permite excluir o comando.




# Tutoriel

## Comutador virtual

Para fazer um comutador virtual, você precisa adicionar 2 comandos
virtual como este :

![virtual5](../images/virtual5.png)

Então você salva e o Jeedom adiciona automaticamente o
ordem de informação virtual :

![virtual6](../images/virtual6.png)

Adicione nos comandos "action" `On` e` Off`, o comando `State`
(isso permite que o Jeedom faça o link com o comando state).

Para ter um bom widget, você precisa ocultar o comando status :

![virtual7](../images/virtual7.png)

Atribua um widget que gerencia o feedback de status aos 2 comandos de ação,
por exemplo, aqui o widget de luz. Para fazer isso, clique no pequeno
roda dentada na frente do comando "On" e na 2ª guia
selecione `light 'como widget :

![virtual8](../images/virtual8.png)

Salve e faça o mesmo para o comando `Off '. E você terá
um bom widget que mudará de estado quando clicado :

![virtual9](../images/virtual9.png)




## Controle deslizante virtual

Para criar um controle deslizante virtual, adicione um comando virtual
assim :

![virtual12](../images/virtual12.png)

Como antes após o backup, o Jeedom automaticamente
crie o comando info :

![virtual13](../images/virtual13.png)

E como antes, é aconselhável vincular a ação ao comando
e esconda.




## Interruptor de alavanca

É assim que se alterna o tipo de alternância.
crie uma ordem virtual :

![virtual14](../images/virtual14.png)

Em seguida, salve para ver o comando status aparecer :

![virtual15](../images/virtual15.png)

Aqui é necessário no valor do comando action colocar
`not (\# [...] [...] [State] #)` (substitua por seu próprio comando) e
vincule o status ao comando action (tenha cuidado, não oculte o
comando state desta vez). Você também deve colocar o comando info em
subtipo binário.

Calcul

Para fazer um cálculo em vários pedidos, é muito fácil ! Il
basta criar um comando do tipo de informação virtual e no
campos de valor colocar seus cálculos. O testador de expressão pode ajudá-lo
nesta fase para validar. Por exemplo, para média
2 temperaturas :

![virtual10](../images/virtual10.png)

Vários pontos a serem feitos corretamente :

-   Escolha o subtipo de acordo com o tipo de informação (aqui
    média, por isso é um numérico),

-   Coloque parênteses nos cálculos, isso permite que você tenha certeza da
    resultado da operação,

-   Coloque a unidade bem,

-   Marque a caixa para registrar, se necessário,



## Pedidos múltiplos


Veremos aqui como fazer um pedido que será desativado 2
luzes. Nada mais simples, basta criar um pedido virtual
e coloque os 2 comandos separados por um `&&` :

![virtual11](../images/virtual11.png)

Aqui, o subtipo de comando deve ser o mesmo que o
subtipos dos comandos controlados, portanto, todos os comandos no
campos de valor devem ter o mesmo subtipo (todos "outros" ou todos
"controle deslizante "ou todo o tipo de cor).




## Feedback do status virtual

Ao usar equipamentos sem retorno
status e se este equipamento for solicitado apenas pela Jeedom, será
possível ter um feedback virtual. Isso requer a criação de um
virtual que executa comandos de ação (ex: On & Off) do equipamento
e quem tem um comando info (status). Então você tem que preencher o
Coluna de parâmetros para cada comando de ação, selecionando o nome
do comando info (status) e fornecendo o valor que ele deve levar.

Também podemos imaginar um virtual que liga / desliga várias lâmpadas
(comandos de ações separados por &&) e, portanto, têm um status
ordem geral.




# Atribuindo um valor pela API

É possível alterar o valor da informação virtual por um
Chamada de API :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Note**
>
> Tenha cuidado para adicionar um / jeedom após \#IP\_JEEDOM \#, se necessário
