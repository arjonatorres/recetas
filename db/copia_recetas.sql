--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY categorias (id, nombre) FROM stdin;
1	Aperitivos y tapas
2	Arroces y cereales
3	Aves y caza
4	Bebidas, cócteles e infusiones
5	Carne
6	Cócteles y bebidas
7	Ensaladas
8	Guisos y Potajes
9	Huevos y lácteos
10	Legumbres
11	Mariscos
12	Pan y bollería
13	Pasta
14	Pescado
15	Postres y dulces
16	Salsas
17	Sopas y cremas
18	Verduras
\.


--
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('categorias_id_seq', 16, true);


--
-- Data for Name: dificultades; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY dificultades (id, nombre) FROM stdin;
1	Fácil
2	Media
3	Difícil
\.


--
-- Name: dificultades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('dificultades_id_seq', 3, true);


--
-- Data for Name: etiquetas; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY etiquetas (id, nombre) FROM stdin;
5	sano
6	pain_dore
7	ligera
8	cena
9	verano
10	batido
11	vegano
12	rapida
\.


--
-- Name: etiquetas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('etiquetas_id_seq', 12, true);


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY usuarios (id, usuario, password, email, auth_key, token_val, created_at, updated_at) FROM stdin;
2	ro	$2a$10$z5OwEc9D1pjBRghtFuL/qejTmA6tCotYXi7GLs5mUpPsNdw8kdHjW	robdp79@gmail.com	\N	\N	2018-12-24 12:16:46	2018-12-24 12:16:46
3	rafaelarjona	$2y$13$jEIgELKa/23.wws2U9W07OqJgjy6o3LqREi0/A0Bgr9HEh3V17Lo.	rafaelarjona.personal@gmail.com	\N	\N	2018-12-24 12:19:31	2018-12-24 12:19:31
5	Esteban	$2y$13$14lYRuOvRX3y32W9QVks8e6U6YSS.4SSg6BDq445tmQf3vNl.K7Y2	foskito1972@gmail.com	\N	\N	2018-12-25 23:36:23	2018-12-25 23:36:23
9	pepe	$2y$13$90H9wtYRdxaxeCxAfOKC3.T./2ZJsYUKDEgLBx1FhAcE5R0s9TtnW	arjonatorres@yahoo.es	\N	\N	2018-12-26 08:40:26	2018-12-26 08:40:26
1	jose	$2a$10$5r/NaYBe.mQYCZ3pFxnk.uqgzFcjbSDnYK.MxTVxTa6sCTzlWsRJa	arjonatorres79@gmail.com	\N	\N	2018-12-24 12:16:46	2018-12-28 17:59:09
4	Ines	$2y$13$naH7.kSGk/kEovFHxIcwsuZqCB6u.AORNS18w40tsZ71DspCNQq/S	inesarjona@hotmail.com	\N	\N	2018-12-24 12:36:52	2018-12-30 20:47:54
\.


--
-- Data for Name: recetas; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY recetas (id, titulo, historia, ingredientes, comensales, comentarios, tiempo, categoria_id, dificultad_id, usuario_id, created_at, updated_at) FROM stdin;
2	Puchero Jerezano	Está el tiempo revuelto, unos días calor, otros frío, así que cuando uno pone los garbanzos a remojar para preparar el puchero no sabe muy bien si al día siguiente mientras se lo come bien calentito le estarán cayendo dos goterones por toda la frente con los calores o si le va a sentar de lujo con el fresquito de afuera.\r\nEn cualquier caso no quería dejar de compartir con vosotros esta receta típica jerezana(que también se preparar muy parecida en otras partes de Andalucía).\r\n	400 gramos de garbanzos (secos)\r\n1/2 pollo (unos 600-700 gramos)\r\n1/4 de kilo de carne de ternera (se suele usar un trozo de jarrete o falda)\r\n1 trozo de jamón\r\n1 hueso blanco (hueso de pata de cerdo con sal)\r\n1 hueso de espinazo\r\n1 trozo de costilla (yo uso de cerdo, pero puedes usar de ternera o un trozo de cada)\r\n1 trozo de tocino (no muy grande o pondrá muy graso el puchero)\r\n1 trozo de añejo (esto es la piel del tocino curada y salada)\r\n1 puerro grande\r\n1 o 2 zanahorias\r\n2 patatas\r\n1 o 2 pencas de apio\r\n1 o 2 nabos\r\n2 litros y medio de agua (10 vasos de agua)	4	Fíjate que no hemos añadido ni pizca de sal. La razón es que los huesos de los avíos del puchero suelen ser bastante salados y ya dan bastante sabor al caldo. De todas formas si en alguna receta notaras el caldo un poco soso solo tendrías que ajustar con un poco de sal y listo.\r\n\r\nSi se te olvida poner los garbanzos en remojo la noche antes de hacer el puchero puedes ir a una carnicería a ver si encuentras garbanzos remojados. Ojo, no confundir los garbanzos remojados con los garbanzos cocidos que vienen en bote. Estos últimos al estar ya cocidos no pueden añadirse al principio de la receta o se desmoronarían y si los añades al final no cogerán el sabor del caldo y no tendrán nada que ver.\r\n\r\nSi compras los garbanzos ya remojados ten en cuenta que el garbanzo remojado pesa más o menos el doble que el garbanzo seco. Esta receta usa 400 gramos de garbanzos secos así que si quieres comprar los garbanzos ya remojados tendrás que comprar el doble (800 gramos).\r\n\r\nSe puede hacer el puchero con menos pollo (1/4 de pollo o un muslo) y con menos garbanzos, pero entonces te saldrá poco pollo y no podrás preparar más recetas con él. Por ejemplo con estas cantidades te da para comer un arroz del puchero para cuatro y luego preparar ropa vieja e incluso croquetas.\r\n\r\nEl añadir más o menos verduras dependerá del uso que le des después a las verduras. Si quieres preparar una crema de verduras tendrás que añadir al menos dos unidades de cada tipo de verduras (2 nabos, 2 zanahorias, ….).\r\n\r\nHacer el puchero en olla normal lleva bastante tiempo porque poner blandas las carnes y los garbanzos requiere un buen rato (mínimo 3 horas). Si no quieres o no puedes esperar tanto tiempo puedes hacer lo siguiente, te prometo que queda un puchero riquísimo y en mucho menos tiempo. Lo que tienes que hacer es usar una olla express o una olla rápida. Sigue la receta hasta que hayas desespumado bien y luego tapas la olla. Deja que coja presión y entonces mantén al fuego entre 15 y 20 minutos (más no o se desmoronarán los garbanzos y las verduras).  Luego quita la presión, destapa y deja que se siga cocinando el puchero como en una olla normal. Estará listo en mucho menos tiempo!!!	3h	7	2	3	2018-12-24 13:17:11	2018-12-26 21:29:29
5	Tocino de cielo	La primera referencia al tocino de cielo data del siglo XIV y su origen se encuentra en Jerez de la Frontera, para ser más exactos, en el convento del Espíritu Santo. Este convento fue el primero femenino situado en esta ciudad, entre nosotros conocida como Capital del Mundo. \r\nAdemás, su origen está estrechamente relacionado con el producto estrella de esta nuestra Capital del Mundo: el vino. El elixir que los fenicios inventaron en nuestra tierra,necesitaba de claras de huevo para su clarificación, limpiándolo así de impurezas. Todas las yemas sobrantes se las donaban a las monjas del convento y éstas, con su increíble ingenio, seguramente auspiciado por unas cuantas copitas de fino "der weno", idearon mezclarlas con almíbar. \r\nAsí surge este manjar jerezano. \r\nDe Jerez al resto del mundo:	12 yemas de huevo\r\n1 vaso y medio de agua\r\n400 g de azúcar\r\n1 cucharada de azúcar avainillada	4	Es muy recomendable tener a mano un buen par de guantes protectores o algún mango desmontable de sartén.\r\nLa fuente llena de agua se puede poner en el horno a máxima temperatura desde el principio, para que el agua esté hirviendo o supercaliente cuando vayamos a introducir la flanera al baño maría.\r\n	2 h	13	2	4	2018-12-30 23:18:05	2018-12-31 09:31:06
3	Tagarninas esparragás con huevo cuajao	Mi favorita!!!	500 g de tagarninas\r\n1 buena rebanada de pan de campo del día anterior (o 2 rebanadas de pan de barra)\r\n4 dientes de ajo\r\n1 cucharadita de Pimentón de la Vera dulce\r\nSal\r\nAceite de oliva virgen extra\r\n200 ml de agua\r\n4 huevos de corral (1 por persona)	4	\N	30min	16	1	3	2018-12-24 13:50:40	2018-12-26 21:29:29
1	Pan casero	¡¡¡Gracias a mi hermano por esta receta!!!	400 g. agua\r\n2 cucharaditas de sal\r\n235 g. harina de fuerza\r\n235 g. harina integral\r\n235 g. harina de espelta\r\n5 g. levadura seca	2	\N	3h	12	1	1	2018-12-24 12:16:52	2019-01-09 20:48:14
9	Berenjenas salteadas con cebolla	\N	1/2 kg. de berenjenas\r\n1 cebolleta mediana\r\naceite de oliva virgen extra\r\nsal\r\noregano\r\nbuen pimentón	2	\N	30min	18	1	1	2019-01-10 19:50:08	2019-01-10 19:34:46
10	Lassi de fresas y plátano	Este lassi de fresas y plátano es una versión de la bebida tradicional hindú a base de yogur y mango	1 plátano\r\n4 fresas\r\n1 cda. de miel (opcional)\r\n1 yogur natural sin azucar\r\n1 chorreon de leche\r\n1 toque de jengibre en polvo\r\n1 toque de pimienta	1	En mi versión aprovecho cualquier fruta de temporada aunque respeto la esencia de la receta con las especias y composición. Puedes poner también unas semillas de cardamomo molidas.\r\nCon la misma receta puedes hacer lassi de kiwi, papaya, piña, manzana… o cualquier fruta a tu gusto. Puedes colar el resultado si quieres eliminar la pulpa o fibras de la fruta.	10min	4	1	1	2019-01-11 17:45:57	\N
11	Mousse de chocolate vegana	Es una receta ideal para esas ocasiones en las que tienes varios aguacates que han madurado a la vez y no sabes muy bien que hacer con ellos.	1 aguacate\r\n1 cda miel\r\n2 cda chocolate en polvo\r\n1 poco de canela\r\n1 chorreon de leche	2	Acompañar con pistachos, nueces, cacahuetes o fresas	20min	15	1	1	2019-01-11 20:28:14	\N
12	Zanahorias glaseadas con miel	Esta hortaliza es un alimento especial para tratar diferentes problemas de salud y si no sabes cómo prepararla aquí tienes una receta original, deliciosa y diferente. La zanahoria glaseada con miel es perfecta para acompañar carnes o pollo asados.	1 zanahoria (2 si son pequeñas)\r\n2 cucharaditas de miel\r\n1 pizca de tomillo seco\r\n2 cucharadita de aceite de oliva\r\n1 cucharadita de mostaza de dijon\r\n1 pizca de sal\r\n1 pizca de pimienta	2	Este plato puedes comerlo solo o servirlo como guarnición de un pollo en salsa de champiñones.	20min	18	1	1	2019-01-11 20:40:06	2019-01-11 19:42:24
14	Salsa de ajo y perejil	Una salsa muy rápida de preparar, polivalente y muy sabrosa que nos va a venir muy bien para utilizar sobre pescados a la plancha, carnes a la plancha, verduras a la plancha o asadas, patatas asadas, pasta, pan tostado, también como aliño para carnes y pescados en barbacoas o al horno, etc.	aceite de oliva\r\najo\r\nperejil\r\nlimón\r\nsal\r\npimienta molida	2	\N	10min	16	1	1	2019-01-11 20:52:27	\N
18	Masa de pizza integral	Si quieres una receta de base de pizza para hacerla a tu gusto, esta es tu receta.\r\nCon esta cantidad de ingredientes salen para hacer 3 pizzas para 2 personas	330gr. harina fuerza\r\n330gr. harina integral\r\n330gr. agua\r\n2 cucharadas aceite\r\n1 cucharadita sal\r\n1 cucharadita y media de levadura	2	Las dos bolas que sobran yo las congelo sin problemas para la  otra ocasión	90min	12	1	1	2019-01-14 22:46:51	\N
\.


--
-- Data for Name: pasos; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY pasos (id, texto, receta_id) FROM stdin;
3	Para hacer el puchero hay que acordarse la noche antes de poner los garbanzos en remojo. Así que ya sabes, enjuaga los garbanzos y ponlos en un cacharro grande cubiertos de agua. Por la mañana habrán doblado su peso y aumentado bastante su volumen. Escúrrelos y enjuágalos bien bajo el chorro del grifo. Ahora coge una olla grande y pon el agua a calentar (unos 2 litros y medio), cuando esté caliente añade los garbanzos con cuidado para no quemarte con el agua.	2
4	Ahora vamos a preparar los avíos del puchero. Coge los huesos (espinazo, costillas y hueso blanco), el tocino y el añejo y enjuágalos bien bajo el chorro del grifo para quitar el exceso de sal (frótalos también con los dedos para desprender las zonas con más sal). Luego ponlos en la olla sobre los garbanzos. A continuación pon el trozo de carne de ternera, el jamón y el pollo. Por último pela el nabo, las patatas, las zanahorias. Quita la parte más verde del puerro y enjuágalo bien para quitarle cualquier resto de arena que pueda traer. Lava el apio quítale las hebras más duras. Mete todas las verduras en la olla. Deja a fuego medio-alto.	2
5	Cuando empiece a salir espuma la iremos retirando con una espumadera.	2
6	Cuando las verduras estén tiernas las sacamos con cuidado a un plato y las reservamos. Dejamos el puchero al fuego hasta que las carnes y los garbanzos estén tiernos.	2
7	Cuando las carnes y los garbanzos están tiernos sacamos las carnes a un plato y dejamos que se enfríen un poco. Tira los huesos y el añejo.	2
8	Con una espumadera limpia sacamos los garbanzos.	2
9	Luego cogemos un colador para colar el caldo del puchero y lo reservamos. A mi en esta ocasión me salió 1 litro y medio de caldo pero esto dependerá de la potencia que le des al fuego y de la cantidad de líquido que se evapore.	2
10	Cuando no quemen las carnes las desmenuzaremos con los dedos para poder utilizarlas luego en la receta que prefiramos. Aquí abajo puedes ver el pollo, la ternera y el jamón desmenuzado. El tocino se guarda entero para quién le guste.	2
11	Las tagarninas son plantas rastreras, es decir, que viven pegadas al suelo básicamente y, por ello, habrá que limpiarlas a conciencia porque suelen traer mucha tierra.\r\n\r\nQuitamos el tronco de la parte inferior para separar los distintos tallos (y dejarlas al estilo espárragos trigueros), los limpiamos un poco del resto de hojas que puedan traer y los troceamos desechando un poco las puntas también (2-3 dedos será suficiente). Es bastante frecuente encontrar pequeños tallos que tienen más bien pinta de espiga de trigo verde, esos también los desecharemos. Por último, lavamos abundantemente debajo del grifo para que suelten toda a tierra que tengan, a conciencia, que ya os digo que suelen traer bastante.	3
12	Con las tagarninas ya troceadas y bien limpias, ponemos una olla con abundante agua a fuego fuerte y, cuando rompa a hervir, echamos las tagarninas, dejándolas cocer unos 5 minutos aproximadamente a partir de que vuelva a hervir. Una vez cocidas, les quitamos el agua y las pasamos por agua fría para cortar la cocción.	3
13	Por otro lado, en la sartén donde las vamos a cocinar, ponemos un poco de aceite de oliva virgen extra para freír el pan y el ajo picado. Cuando empiecen a dorarse, los echamos en un mortero y hacemos un majao.	3
14	Si nos hemos quedado sin aceite en la sartén, echamos otro chorrito, lo dejamos hasta que coja un poco de temperatura e incorporamos la cucharada de Pimentón de la Vera dulce removiendo al instante para evitar que se queme (de ahí que el aceite no tiene que estar muy caliente).	3
15	Incorporamos las tagarninas a la sartén y removemos para que se impregnen bien con el pimentón. Echamos el agua y el majao que hemos hecho con el pan y los ajos, subimos a fuego alto y vamos removiendo de vez en cuando hasta que empiecen a ponerse tiernas las tagarninas. Si es necesario incorporar más agua, vamos echando poco a poco, tanto como se necesite.	3
16	Por último, cascamos los huevos encima y dejamos que se cuajen. Como os pongo en los ingredientes, si usáis unos buenos huevos de corral o de campo en vez de unos normales de supermercado, vuestro paladar os lo agradecerá :) Haced un esfuerzo por comprarlos porque esta receta se los merece.	3
18	Necesitamos un recipiente conocido como flanera y será en éste donde cocinemos el almíbar.	5
21	Ahora caramelizamos ese sobrante de almíbar que hemos reservado en el fondo de la flanera. Será breve ya que es poca cantidad la que debemos dejar. Esperamos a que se solidifique.	5
22	Añadimos sobre el caramelo solidificado la mezcla de yemas y almíbar. Cerramos la flanera y lo metemos en la fuente llena de agua muy caliente que habremos puesto al máximo en el horno. Dejamos cocinar 1 h al baño maría también al máximo de potencia. Siempre y cuando el máximo no sea el de un horno de incineración. En ese caso lo dejaríamos a 250º.	5
23	Cuando ya hayan pasado 60 min podemos comprobar si está bien cuajado introduciendo, por ejemplo, un palillo chino. Si no sale líquido significa que estará listo. \r\nLo dejamos enfriar a temperatura ambiente. Posteriormente lo pasamos a la nevera y cuando esté frío (se recomienda 24 horas) lo volcamos sobre un plato. El caramelo que dejamos al fondo no va a caer cuando volquemos el tocino de cielo (ara...), pero no nos importa porque en realidad sólo lo queremos para que dé color a la parte de arriba del tocino de cielo. \r\nSi finalmente cayese, podemos quitárselo si no lo queremos, ya que estará duro y espachurraríamos el tocino de cielo de abajo. \r\nTasháaaaaaaaaaaaan!!!!!!!\r\n	5
20	Mientras hierve el almíbar, separamos las yemas de las claras, añadimos 2 cucharadas de agua y reservamos las yemas en un bol o cuenco, teniendo en cuenta que debe ser lo suficientemente grande para añadir el almíbar cuando haya llegado al punto de goma. Lo añadiremos muy lentamente y removiendo constantemente. \r\nEn la flanera dejaremos un poco de almíbar para caramelizarlo. Deberá cubrir como mínimo toda la base de la flanera.	5
19	Añadimos a la flanera el vaso y medio de agua, los 400 g de azúcar y la cucharada de azúcar avainillada para hacer el almíbar. El fuego lo dejamos fuerte y que hierva un rato. Vamos removiendo muy de vez en cuando hasta que llegue a punto de goma. Para comprobar que nos encontramos en este punto, podemos sacar una cucharada de almíbar y que al volcarlo caiga un hilo filo que se corte y suba o que casi no se corte.\r\n\r\n	5
1	Echar todos los ingredientes en el bol y poner el programa 2 de la Moulinex Pain Doré (1kg. y minimo dorado)	1
26	Cocer las berenjenas sin pelar y troceadas a taquitos, con el agua hirviendo unos diez minutos, escurrir y reservar. Pelar y picar la cebolla y pocharla en aceite en un perol. Cuando esté transparente, añadir la berenjenas, saltear y añadir la sal, el pimentón y el orégano. Servir. Puede llevar también un huevo en revuelto	9
27	Ponemos todos los ingredientes juntos y a la vez en el vaso de la batidora y trituramos unos minutos hasta que quede bien mezclado y perfectamente molido. probamos de dulzor para rectificar la cantidad de azúcar o de miel si es necesario.	10
28	Dejamos enfriar en la nevera hasta el momento de servir. Servimos bien frío con un poco de menta picada	10
29	Pela el aguacate y añade el resto de ingredientes en un bol. Tritura bien con ayuda de una batidora hasta obtener una textura cremosa. Ajusta la consistencia deseada con la leche dependiendo de si te gusta más o menos líquida.	11
30	Guarda en la nevera 1-2 horas (si eres capaz de resistirte), ganará en sabor	11
31	En una olla con un poco de agua, añadir las zanahorias cortadas en tiras gruesas. Cocinar hasta que estén blandas.	12
32	Para hacer el marinado, mezclar la mostaza Dijon, el aceite de oliva, la miel, el tomillo, sal y pimienta.	12
33	Cuando el agua se esté terminado de evaporar, agregar está mezcla a las zanahorias y revolver. Cocinar a fuego bajo durante 5 minutos, rectificar sabor con sal y pimienta si es necesario.	12
36	En un recipiente ponemos el aceite de oliva, le añadimos medio ajo (es mejor empezar poco a poco e ir añadiendo después al gusto), el perejil troceado, un poco de sal, pimienta molida, el zumo de medio limón y lo vamos a pasar por la batidora (también podríais hacerlo a  mano en el mortero, esto ya al gusto).	14
37	Una vez bien batido y unidos los ingredientes lo probamos y corregimos de sal y si acaso de limón (si os gusta más, podéis utilizar un vinagre suave).	14
43	Cogemos todos los ingredientes y los metemos en el bol	18
44	Ponemos el programa número 9 de la Moulinex Pain Doré	18
45	Dividimos la masa en 3 y aplanamos una de ellas con un rodillo en la encimera espolvoreada de harina	18
\.


--
-- Name: pasos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('pasos_id_seq', 45, true);


--
-- Data for Name: recetas_etiquetas; Type: TABLE DATA; Schema: public; Owner: jose
--

COPY recetas_etiquetas (receta_id, etiqueta_id) FROM stdin;
1	5
1	6
9	7
9	5
9	8
10	9
10	10
11	11
11	5
12	5
14	12
18	5
18	6
\.


--
-- Name: recetas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('recetas_id_seq', 18, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: jose
--

SELECT pg_catalog.setval('usuarios_id_seq', 9, true);


--
-- PostgreSQL database dump complete
--

