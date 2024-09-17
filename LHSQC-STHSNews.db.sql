BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "LeagueNews" (
	"Number"	INTEGER,
	"Time"	timestamp,
	"TeamNumber"	integer,
	"TeamNewsNumber"	integer,
	"Owner"	string,
	"Title"	string,
	"Message"	string,
	"Remove"	Boolean,
	"WebClientModify"	Boolean,
	"AnswerNumber"	integer,
	PRIMARY KEY("Number" AUTOINCREMENT)
);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (2,'2024-03-09 10:02:40',21,0,'Dominic Bolduc','On Vise La Coupe à Ottawa','<p>Depuis son accession au poste de directeur g&eacute;n&eacute;ral des S&eacute;nateurs d&#39;Ottawa, le nouveau leader de l&#39;&eacute;quipe Dom Bolduc a clairement &eacute;nonc&eacute; l&#39;objectif ultime : hisser la c&eacute;l&egrave;bre Coupe Stanley au-dessus de sa t&ecirc;te et offrir &agrave; la ville un moment d&#39;euphorie inoubliable.</p>

<p>Ce n&#39;est pas seulement une ambition personnelle, mais une vision partag&eacute;e par chaque membre de l&#39;organisation. Dans les coulisses, les coups de fil incessants, les n&eacute;gociations ardues et les analyses minutieuses des talents ne sont que quelques-unes des nombreuses pi&egrave;ces d&#39;un puzzle complexe que le directeur g&eacute;rant et son &eacute;quipe doivent assembler pour atteindre cet objectif.</p>

<p>Alors que la saison progresse, chaque victoire et chaque d&eacute;faite sont scrut&eacute;es avec une attention m&eacute;ticuleuse, car elles repr&eacute;sentent des &eacute;tapes cruciales sur la route de la Coupe Stanley.</p>

<p>Malgr&eacute; les hauts et les bas, une chose reste constante : la ferme conviction que le succ&egrave;s final est &agrave; port&eacute;e de main.</p>

<p>La qu&ecirc;te de la Coupe Stanley est l&#39;ultime r&eacute;compense de la LHSQC et les S&eacute;nateurs d&#39;Ottawa sont pr&ecirc;ts &agrave; relever le d&eacute;fi et &agrave; &eacute;crire leur nom dans les annales du hockey.</p>

<p>&nbsp;</p>

<p><img alt="" src="https://media.d3.nhle.com/image/private/t_ratio16_9-size40/f_auto/prd/hdcfjxfpjxkzejss7khe.jpg" style="height:338px; margin-left:100px; margin-right:100px; width:600px" /></p>
','False','True',0);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (3,'2024-03-09 19:35:11',8,0,'David Cassabon','petit test','<p>Beau test !&nbsp;</p>
','False','True',2);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (4,'2024-03-13 03:10:17',22,0,'Jacob Lacharite','Échange majeur entre les Flyers et les Sabres','<p>Le meilleur pointeur de l&#39;&eacute;quipe et seul repr&eacute;sentant aux match des &eacute;toiles pour Philadelphie, Matthew Tkachuk, &agrave; &eacute;t&eacute; &eacute;chang&eacute; &agrave; Buffalo !</p>

<p>Apr&egrave;s avoir &eacute;t&eacute; approch&eacute; par les Blues au sujet de son joueur vedette, le DG Jacob Lacharit&eacute; a d&eacute;cid&eacute; d&#39;&eacute;couter les offres des autres &eacute;quipes &agrave; son sujet. Apr&egrave;s quelques semaines de discussions avec trois &eacute;quipes diff&eacute;rentes, ce sont finalement les Sabres du DG Alex Lapointe qui ont su faire une offre que Philly ne pouvait refuser.&nbsp;</p>

<p>Buffalo c&egrave;de les ailiers Matt Boldy et Matias Maccelli ainsi qu&#39;un choix de premi&egrave;re ronde en 2024.</p>

<p>S&#39;ajoute &agrave; Matthew Tkachuk, le robuste ailier Nathan Bastian ainsi qu&#39;un choix de 4e ronde en 2024.</p>

<p>Dans son point de presse, Lacharit&eacute; a soulign&eacute; le passage de Tkachuk avec les Flyers : &laquo; C&#39;est bien sur avec tristesse que nous laissons partir Matthew. Il aura marqu&eacute; non seulement ses co&eacute;quipiers et ses dirigeants, mais aussi toute la ville de Philadelphie. &raquo;</p>

<p>En entrevue dans le vestiaire, le capitaine Aleksander Barkov a souhait&eacute; bonne chance &agrave; son ami dans sa nouvelle &eacute;quipe.</p>

<p>Le raisonnement derri&egrave;re cet &eacute;change est compr&eacute;hensible dans les deux camps. De leur c&ocirc;t&eacute;, Buffalo solidifie leur candidature au meilleur top 6 de la ligue en r&eacute;unissant les fils de Keith Tkachuk. &Agrave; l&#39;approche des s&eacute;ries &eacute;liminatoires, la fougue et le talent offensif de cette &eacute;quipe est redoitable et pourrait faire peur &agrave; n&#39;importe quelle &eacute;quipe. Pour ce qui est des Flyers ils misent sur l&#39;ajout deux jeunes attaquants &eacute;tablis et dans la ligue qui d&eacute;bordent de talents aux &acirc;ges de 22 ans pour Boldy et 23 ans pour Maccelli. &Agrave; &ccedil;a s&#39;ajoute un choix de premi&egrave;re ronde qui est toujours une bonne arme &agrave; avoirpour une &eacute;quipe en &#39;&#39;<em>Reset&#39;&#39;.</em></p>

<p>&nbsp;</p>

<p><em>Gr</em>egory Walton,</p>

<p>&nbsp;</p>

<p>The Philadelphia Inquirer</p>

<p>&nbsp;</p>
','False','True',0);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (5,'2024-04-02 02:30:30',17,0,'Simon Pradella','Le statut quo (ou presque) à Nashville','<p>Si la tendance se maintient, les Predators de Nashville feront partie du tournoi printannier cette saison (contre toute attente) ! Plusieurs amateurs se demandaient si le DG Pradella allait &ecirc;tre acheteur &agrave; sa premi&egrave;re date limite des transactions comme DG de l&#39;&eacute;quipe.&nbsp;</p>

<p>3 jours avant la date limite des transactions, le DG a mentionn&eacute; aux medias qu&#39;il serait surprenant que les Preds fassent un grand coup d&#39;ici le 4 avril.</p>

<p><em>&#39;&#39; Nous avons pleinement confiance &agrave; notre premier trio qui fait un travail exceptionnel, ainsi qu&#39;&agrave; notre d&eacute;fensive et notre gardien de but qui nous permettent de gagner des matchs. Notre point faible cette saison est l&#39;apport offensif de nos joueurs de soutien, c&#39;est pourquoi nous sommes all&eacute;s cherche de la profondeur en faisant l&#39;acquisition de Corey Perry plus t&ocirc;t cette saison, et de Tanner Pearson il y a quelques heures&#39;&#39;</em></p>

<table border="1" cellpadding="1" cellspacing="1" style="width:500px">
	<tbody>
		<tr>
			<td>Skinner</td>
			<td>Karlsson</td>
			<td>Wilson</td>
		</tr>
		<tr>
			<td>Bunting</td>
			<td>Johnson</td>
			<td>Foegele</td>
		</tr>
		<tr>
			<td>Pearson</td>
			<td>Bjugstad</td>
			<td>Perry</td>
		</tr>
		<tr>
			<td>Martinook</td>
			<td>Sgarbossa&nbsp;</td>
			<td>Blackwell/Johnsson</td>
		</tr>
	</tbody>
</table>

<table border="1" cellpadding="1" cellspacing="1" style="width:500px">
	<tbody>
		<tr>
			<td>Barrie</td>
			<td>McDonagh</td>
		</tr>
		<tr>
			<td>Dumba</td>
			<td>Durzi</td>
		</tr>
		<tr>
			<td>Clifton</td>
			<td>Bear</td>
		</tr>
		<tr>
			<td>Mrazek&nbsp;&nbsp;</td>
			<td>Nedeljkovic</td>
		</tr>
	</tbody>
</table>

<p>C&#39;est donc avec l&#39;alignement actuel que nous pouvons nous attendre &agrave; voir les Predators se battre pour une place en s&eacute;rie, et qui sait tenter de faire un bout de chemin ce printemps.&nbsp;</p>

<p>Il faut aussi souligner que m&ecirc;me si le DG Pradella aurait voulu aller chercher un joueur &eacute;toile, sa banque d&#39;espoirs quasi-vide rendait cela tr&egrave;s difficile.&nbsp;</p>

<p><em>&#39;&#39; Malgr&eacute; la belle surprise cette saison je pense que nous avons beaucoup de travail &agrave; faire pour remettre cette &eacute;quipe sur les rails pour de nombreuses ann&eacute;es, et la cl&eacute; est de bien rep&ecirc;cher. Je ne veux pas sacrifier le futur de l&#39;&eacute;quipe pour un joueur de location, et je me dois de faire confiance &agrave; mes joueurs puisque jusqu&#39;&agrave; maintenant, ils ne cessent de surprendre! &#39;&#39;&#39;</em></p>
','False','True',0);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (6,'2024-09-09',1,0,'David Cassabon','Gaudreau brothers to be honoured at funeral in Pennsylvania','<p>Depuis son accession au poste de directeur g&eacute;n&eacute;ral des S&eacute;nateurs d&#39;Ottawa, le nouveau leader de l&#39;&eacute;quipe Dom Bolduc a clairement &eacute;nonc&eacute; l&#39;objectif ultime : hisser la c&eacute;l&egrave;bre Coupe Stanley au-dessus de sa t&ecirc;te et offrir &agrave; la ville un moment d&#39;euphorie inoubliable.</p>

<p>Ce n&#39;est pas seulement une ambition personnelle, mais une vision partag&eacute;e par chaque membre de l&#39;organisation. Dans les coulisses, les coups de fil incessants, les n&eacute;gociations ardues et les analyses minutieuses des talents ne sont que quelques-unes des nombreuses pi&egrave;ces d&#39;un puzzle complexe que le directeur g&eacute;rant et son &eacute;quipe doivent assembler pour atteindre cet objectif.</p>

<p>Alors que la saison progresse, chaque victoire et chaque d&eacute;faite sont scrut&eacute;es avec une attention m&eacute;ticuleuse, car elles repr&eacute;sentent des &eacute;tapes cruciales sur la route de la Coupe Stanley.</p>

<p>Malgr&eacute; les hauts et les bas, une chose reste constante : la ferme conviction que le succ&egrave;s final est &agrave; port&eacute;e de main.</p>

<p>La qu&ecirc;te de la Coupe Stanley est l&#39;ultime r&eacute;compense de la LHSQC et les S&eacute;nateurs d&#39;Ottawa sont pr&ecirc;ts &agrave; relever le d&eacute;fi et &agrave; &eacute;crire leur nom dans les annales du hockey.</p>

<p>&nbsp;</p>

<p><img alt="" src="https://media.d3.nhle.com/image/private/t_ratio16_9-size40/f_auto/prd/hdcfjxfpjxkzejss7khe.jpg" style="height:338px; margin-left:100px; margin-right:100px; width:600px" /></p>
',NULL,NULL,NULL);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (7,'2024-09-09',2,0,'Jacob Lacharite','Stützle rejects rumours around agent change: ''I love being in Ottawa''','<p>Ottawa Senators centre Tim Stützle has rejected the idea that his reasoning for switching agent this off-season was related to his future the team. 

“I love being in Ottawa,” Stützle told reporters at the team''s charity golf tournament on Monday as he denied any connection to wanting a trade from the team.

Bruce Garrioch of Postmedia adds that he''s led to believe the change was centred around marketing opportunities in Europe for the German forward.</p>
',NULL,NULL,NULL);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (8,'2024-09-09',3,0,'Dominic Bolduc','Oilers GM Bowman: ''I don’t have any animosity or issues with Doug Armstrong''','<p>The dual offer sheets from the St. Louis Blues that targeted the Oilers last month are simply part of the business, Edmonton general manager Stan Bowman says. 

Bowman told TSN Hockey Insider Pierre LeBrun in The Athletic(opens in a new tab) there will be no lasting bad blood between the two teams after Doug Armstrong successfully acquired Philip Broberg and Dylan Holloway with the offer sheets.

“No, I think things are fine,” Bowman said. “I’ve known Doug a long time. He’s a very bright guy, a good person. I think sometimes more is made out of that.

“He was trying to do what he could to make his team better. Once you get past the surprise of it, and you then roll your sleeves up and get to work on what you want to do, I don’t think there’s any value in holding grudges. I mean, what good is going to come out of that?</p>',NULL,NULL,NULL);
INSERT INTO "LeagueNews" ("Number","Time","TeamNumber","TeamNewsNumber","Owner","Title","Message","Remove","WebClientModify","AnswerNumber") VALUES (9,'2024-09-09',4,0,'Simon Pradella','Predators sign F Parssinen to one-year extension','<p>Parssinen, 23, appeared in 44 games with the Predators last season, recording eight goals and 12 points. He appeared in one playoff game before his team lost to the Vancouver Canucks in the first round.

The 6-foot-3 centre is coming off his three-year, entry level deal he signed in 2021.

Drafted 210th overall by the Predators in 2019, Parssinen has 14 goals and 37 points in 89 career games.

Parssinen represented Finland at the 2021 World Juniors in Edmonton, recording two goals and four points in a bronze-medal finish.</p>',NULL,NULL,NULL);
COMMIT;
