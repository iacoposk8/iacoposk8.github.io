function lingua()
{
	this.tutorial_frame="Questi sono i frame ovvero i fotogrammi dell'animazione che stiamo creando. La scena che abbiamo creato finora nella nostra area di lavoro è il punto di inizio; se clicchiamo su un frame successivo a quello attuale (frame zero se non avete ancora cliccato su nessun frame), non necessariamente consecutivo, possiamo per esempio spostare, ruotare, scalare o qualunque altra modifica della scena e, questa nuova riorganizzazione dell'immagine rappresenterà la fine della nostra animazione. Quindi per fare un'animazione non serve modificare tutti i frame (o fotogrammi) dal punto A al punto B ma basterà creare solo la scena del frame iniziale (lo zero) e quella del frame finale (che selezionerai tu). Tutti i frame intermedi verranno creati automaticamente dal software distribuendo in modo equo le modifiche su tutti i frame che stanno tra l'inizio e la fine dell'animazione.<br>Per provare, una volta creato un oggetto, clicca su un frame, poi nella barra orizzontale sottostante clicca con il tasto destro del mouse e scegli di creare un interpolazione.";
	this.tutorial_agg_frame="Scrivi qua il numero di frame che vuoi aggiungere a quelli già presenti";
	this.tutorial_agg_frame_button="clicca qua per aggiungere i frame scritti nel campo a sinistra";
	this.tutorial_ms="Inserisci il tempo in millisecondi di durata di ogni frame (1 secondo = 1000 millisecondi)";
	this.tutorial_ultimo_frame="Inserisci il numero dell'ultimo frame, dove si dovrà fermare l'animazione";
	this.errore_ins_ms="Il campo contenente il tempo in millisecondi per ogni frame deve essere un valore numerico";
	this.errore_ins_frame="Il campo contenente il numero dell'ultimo frame dell'animazione deve essere un valore numerico";
	this.errore_base_altezza="Base e altezza devono essere numeri!";
	this.errore_trasparenza="la trasparenza dello sfondo deve essere un valore compreso tra zero e uno (anche decimali)";
	this.tutorial_inizio="Clicca su uno degli strumenti di disegno in alto a destra";
	this.come_disegnare="Per disegnare una forma/testo basta posizionare il mouse nel riquadro sottostante (bianco se non avete cambiato il colore) cliccate nel punto dove vorreste disegnare la forma scelta e, continuando a tenere premuto, spostate il mouse nel piano per decidere le dimensioni della figura";
	this.tutorial_disegnare_linee="clicca nel riquadro sottostante (bianco se non avete cambiato il colore) per creare i vari punti che comporranno la linea, quando non vuoi creare più altri punti premi 'invio' per terminare";
	this.tutorial_selezione="clicca sugli oggetti disegnati per poterli selezionare. Una volta selezionati potrai spostare, ingrandire e ridurre l'oggetto. Inoltre una volta selezionato l'oggetto, se hai attiva la schermata di dettaglio, potrai accedere alle modifiche più avanzate.";
	this.tutorial_multi_selezione="Premi in un punto del riquadro sottostante (bianco se non avete cambiato il colore) e tenendo premuto il tasto, sposta il mouse creando un area, entro la quale gli oggetti verranno selezionati e potranno successivamente, dalla schermata di dettaglio essere spostati, ruotati e scalati.";
	this.tutorial_over_selezioni="questo strumento non serve per creare forme geometriche o immagini ma per selezionare quelle esistenti così da poterle modificare";
	this.sblocca_animazioni="<br>------------------<br>per disegnare basta spostare il mouse nell'area di lavoro, cliccare, tenere premuto e trascinare il cursore per poi rilasciare il bottone una volta finito.<br><br>Può capitare che il browser interpreti il tascinamento del mouse come tentativo di selezione di uno o più elementi della pagina rendendo impossibile il completamento dell'operazione lanciata nell'HCA. In questi casi basta premere invio o esc per completare l'operazione."
	this.tutorial_cerchio="questo strumento serve per creare cerchi regolari"+this.sblocca_animazioni;
	this.tutorial_quadrato="questo strumento serve per creare quadrilateri"+this.sblocca_animazioni;
	this.tutorial_ellisse="questo strumento serve per creare oggetti di forma ovale/ellittica"+this.sblocca_animazioni;
	this.tutorial_testo="questo strumento serve per creare testi"+this.sblocca_animazioni;
	this.tutorial_poligono="questo strumento serve per creare poligoni regolari"+this.sblocca_animazioni;
	this.tutorial_linea="questo strumento serve per creare linee e tracciati.<br>Per disegnare una linea basta cliccare nell'area di lavoro dove si vuole i punti e una volta finito premere invio o esc.";
	this.tutorial_immagine="questo strumento serve per caricare immagini nell'area di lavoro";
	this.tutorial_multiselezione="questo strumento permette di selezionare più oggetti assieme per poterli poi spostare, ruotare e scalare";
	this.tutorial_colore_sfondo="cliccando qua si aprirà una finestra dove è possibile cambiare il colore di sfondo degli oggetti che si andranno a creare";
	this.tutorial_colore_bordo="cliccando qua si aprirà una finestra dove è possibile cambiare il colore di contorno degli oggetti che si andranno a creare";
	this.tutorial_colore_area_lavoro="cliccando qua si aprirà una finestra dove è possibile cambiare il colore di sfondo dell'area di lavoro, le modifiche saranno visibili solo dopo che premerai il tasto 'Modifica area di lavoro'";
	this.tutorial_spessore_area_lavoro="Quando selezioni un oggetto si contorna di una linea verde, con questo campo puoi decidere lo spessore di queta riga";
	this.tutorial_base_area_lavoro="inserisci qua la larghezza in px del tuo progetto (area di lavoro), le modifiche saranno visibili solo dopo che premerai il tasto 'Modifica area di lavoro'";
	this.tutorial_altezza_area_lavoro="inserisci qua l'altezza in px del tuo progetto (area di lavoro), le modifiche saranno visibili solo dopo che premerai il tasto 'Modifica area di lavoro'";
	this.tutorial_button_area_lavoro="cliccando qua è possibile rendere visibili le modifiche per altezza, larghezza e colore dell'area di lavoro";
	this.tutorial_alpha_area_lavoro="inserisci qua un valore compreso tra zero e uno per settare la trasparenza dell'area di lavoro (se zero è trasparente)";
	this.tutorial_annulla="cliccando qua è possibile annullare l'ultima operazione fatta";
	this.tutorial_ripeti="cliccando qua è possibile ripristinare un operazione precedentemente annullata";
	this.tutorial_play="premi qua per avviare l'animazione. Se sei posizionato sull'ultimo frame della tua animazione e premi play non vedrai muoversi nulla perchè l'animazione quando verrà avviata immediatamente giunge al termine. Clicca quindi sul frame zero e premi play (il tasto dove sei posizionato) per vedere interamente la tua animazione.";
	this.tutorial_stop="premi qua per fermare l'animazione in corso";
	this.tutorial_dettagli="clicca qua per aprire la schermata di dettaglio dell'oggetto selezionato. La schermata rimarrà vuota se non hai selezionato nessun oggetto. Per selezionare un oggetto clicca sullo strumento con la freccia del mouse e infine clicca su un oggetto nel riquadro di lavoro e vedrai la schermata con tutti i dettagli (modificabili) dell'oggetto";
	this.tutorial_tutorial="Clicca qua per aprire la finestra che ti spiegherà come utilizzare il programma al meglio";
	this.opzioni_documento="Opzioni documento";
	this.creazione_oggetto="Creazione oggetto";
	this.modifica_area_lavoro="Modifica area lavoro";
	this.tutorial_errore="questo pulsante si illuminerà quando verrà riscontrato un errore nel programma. Se succede, segui le operazioni per segnalarcelo!";
	this.tutorial_esporta="clicca qua per esportare il tuo lavoro in un formato (html) che potrai utilizzare per le tue pagine web. Inoltre si aprirà una tendina dove potrai scegliere se esportare il progetto come animazione o come immagine fissa.";
	this.tutorial_salva="clicca qui per salvare il tuo lavoro in un formato (xml) che potrai utilizzare solo nell'Html canvas animation. Questa funzione è utile per interrompere le lavorazioni sul progetto e, salvarne lo stato attuale per riaprirle e modificarle in un secondo momento";
	this.tutorial_apri="Con questo tasto possiamo accedere ad un menu che ci permetterà di ripristinare un lavoro precedentemente salvato (col tasto salva).";
	this.colore="Colore"; 
	this.trasparenza="Trasparenza"; 
	this.larghezza="Larghezza";
	this.altezza="Altezza";
	this.spessore="Marcatura";
	this.dettagli_oggetto="Dettagli oggetto";
	this.aggiunta_frame="Aggiunta frame";
	this.durata_frame="Durata frame (ms)";
	this.frame_finale="Frame finale";
	this.cambia_colore="Cambia colore";
	this.contorno="Contorno";
	this.riempimento="Riempimento";
	this.spessore_bordo="spessore bordo";
	this.composizione="Composizione";
	this.posizione_x="Posizione x";
	this.posizione_y="Posizione y";
	this.angolo="Angolo";
	this.raggio="Raggio";
	this.angolo_inizio="Angolo inizio";
	this.angolo_fine="Angolo fine";
	this.tipo_tracciato="Tipo tracciato";
	this.tipo_chiusura_tracciato="tipo chiusura tracciato";
	this.tipo_angoli_tracciato="tipo angoli tracciato";
	this.gradiente_riempimento="Gradiente riempimento";
	this.gradiente_contorno="Gradiente contorno";
	this.aperto="Aperto";
	this.chiuso="Chiuso";
	this.base="Base";
	this.smussatura_angoli="Smussatura angoli";
	this.numero_angoli="Numero angoli";
	this.testo="Testo";
	this.font="Font";
	this.nessun_errore="Nessun errore riscontrato";
	this.errore_doc='"<h1><strong>Errore</strong></h1><br>Errore nell\'ultima procedura eseguita.<br>Potrebbe non essere nulla, come per esempio se avete lasciato vuoto o a zero un campo dei dattagli, provate a premere sul tasto annulla e se l\'errore si ripete aiutaci a migliorare il programma.<br><br><a href=\'mailto:iacopo.guarneri@alice.it?subject=Errore HCA&body=Salve, ho riscontrato un problema nel programma (Html Canvas Animation) che presenta il seguente codice errore:%0d%0a %0d%0a"+storico[punta_storico]+"\'>Segnala errore</a><br><br>Altrimenti scrivici nella sezione <a href=\'index.php/contatti\'>Contatti</a>, clicca sulla voce \'Modulo contatti\' per scriverci, per aiutarci nella risoluzione del problema inviaci il seguente codice errore:<br><br><div style=\'height:50px; overflow:auto; border:3px dashed #444; padding:15px;\'>"+storico[punta_storico]+"</div>"';
	this.esporta="Esporta";
	this.animazione="Animazione";
	this.immagine_fissa="Immagine fissa";
	this.apri="Apri";
	this.inserisci_testo="Inserisci il testo";
	this.lineare="Lineare";
	this.radiale="Radiale";
	this.annulla="Annulla (ctrl+z)";
	this.ripeti="Ripeti (ctrl+y)";
	this.mostra_errori="Mostra se si sono verificati errori al programma";
	this.apri_title="Apri progetto salvato (xml)";
	this.salva_title="Salva progetto (xml)";
	this.esporta_title="Esporta progetto (html)";
	this.riempimento_title="Cambia il colore oggetto";
	this.contorno_title="Cambia il colore del bordo";
	this.selezione="Seleziona oggetti";
	this.cerchio="Disegna cerchi";
	this.quadrato="Disegna quadrati";
	this.ovale="Disegna ovali";
	this.poligono="Disegna poligoni";
	this.testo="Disegna testi";
	this.linea="Disegna linee";
	this.immagine="Importa immagini";
	this.multi_selezione="Seleziona più oggetti";
	this.timeline_label="Timeline";
	this.crea_n_frame="Crea interpolazione sui sottolivelli di questo frame";
	this.distruggi_n_frame="Distruggi interpolazione sui sottolivelli di questo frame";
	this.aggiungi="Aggiungi";
	this.mostra_nascondi_sottolivelli="Mostra/nascondi i sottolivelli dalla vista timeline";
	this.blocca_sblocca="Blocca/sblocca livello";
	this.mostra_nascondi="Mostra/nascondi livello";
	this.sposta_su="Sposta in su il livello";
	this.sposta_giu="Sposta in giu il livello";
	this.sottolivello="Fa diventare un sottolivello del livello che sta sopra";
	this.livello="Selezionando un frame <img src='immagini/frame.png'> e poosizionandoti sulla timeline di un livello (come stai facendo ora) col tasto destro del mouse potrai aprire un menuche ti permetterà di creare o distruggere una transizione della tua animazione.";
	this.interpolazione="Questi simboli indicano dove hai creato una transizione nella tua animazione, cliccandoci sopra e tenendo premuto il tasto del mouse potrai spostarlo prima o dopo nella timeline.";
	this.scala_del="Scala del";
	this.ruota_di="Ruota di";
	this.gradi="Gradi";
	this.esegui="Esegui";
	this.sposta_di="Sposta oggetti di";
	this.line_tool="Trasforma il punto selezionato in un angolo rigido";
	this.bez_tool="Trasforma il punto selezionato in un angolo smussato";
	this.aggiungi_punto="Aggiungi un punto alla tua linea";
	this.rimuovi_punto="Rimuovi un punto dalla tua linea";
}