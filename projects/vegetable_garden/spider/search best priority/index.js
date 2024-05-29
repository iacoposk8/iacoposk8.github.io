const fs = require('fs');
(function() {
	var Carbohydrate_val=60;
	var Protein_val=15;
	var Fat_val=25;
	var gen="Males";
	var age=25;
	var weight=65;
	var height=170;
	var activity=3;
	var extra=undefined;

	function efficientVegetable(){
		this.gda;
		this.food;
		this.rese;
		this.activity_cal={
			"Males":{
				"1":13,
				"2":14,
				"3":15,
				"4":16,
				"5":17
			},
			"Females":{
				"1":11.5,
				"2":12.5,
				"3":13.5,
				"4":14.5,
				"5":15.5
			}
		};
		var self=this;

		this.getJson=function(file){
			return JSON.parse(fs.readFileSync(file));
		}
		this.gdaCalculate=function(gen,age,weight,height,activity,extra){
			var sel='[';
			if(typeof extra !== "undefined")
				sel+='"'+extra+'"';
			else if(age<=8)
				sel+='"Children"';
			else
				sel+='"'+gen+'"';

			sel+='][';
			if(age<=3)
				sel+='"a1b3"';
			if(age>=4 && age<=8)
				sel+='"a4b8"';
			if(age>=9 && age<=13)
				sel+='"a9b13"';
			if(age>=14 && age<=18)
				sel+='"a14b18"';
			if(age>=19 && age<=30)
				sel+='"a19b30"';
			if(age>=31 && age<=50)
				sel+='"a31b50"';
			if(age>=51 && age<=70)
				sel+='"a51b70"';
			if(age>=71)
				sel+='"b70"';
			sel+=']';

			//peso ideale
			if(gen=="Females")
				var ideal_weight=(1.97*(height-152)+100)*0.454;
			if(gen=="Males")
				var ideal_weight=(2.36*(height-152)+106)*0.454;

			//calcolo calorie
			var act_ind=eval('self.activity_cal["'+gen+'"]["'+activity+'"]');
			var cal= weight*(act_ind/0.454);

			//calcolo grassi, carboidrati, proteine
			var balance=self.dietBalancing(cal);

			//creo l'oggetto da ritornare
			var ret={};
			ret["Ideal weight"]={value:ideal_weight, unit:"kg"};
			ret["Calories"]={value:cal, unit:"kcal"};
			ret["Carbohydrate"]={value:balance.Carbohydrate, unit:"g"};
			ret["Protein"]={value:balance.Protein, unit:"g"};
			ret["Fat"]={value:balance.Fat, unit:"g"};

			for (var key in self.gda) {
				ret[key]={value:eval('self.gda["'+key+'"]'+sel), unit:eval('self.gda["'+key+'"]["unit"]')};
			}
			return ret;
		}
		
		this.tofloat=function(n){
			if(typeof n !== "undefined")
				n=n.toString().replace(",",".");
			return parseFloat(n);
		}
		
		this.dietBalancing=function(cal){
			var carb=((cal/100)*parseInt(Carbohydrate_val))/4;
			var prot=((cal/100)*parseInt(Protein_val))/4;
			var gras=((cal/100)*parseInt(Fat_val))/9;
			return {"Carbohydrate":carb, "Protein":prot, "Fat":gras};
		}
		
		this.difference=function(a,b){
			if(a>b)
				return a-b;
			else
				return b-a;
		}

		this.getFoodBalancing=function(elems){
			var c=self.difference(((elems.Carbohydrate*4)/elems.Calories)*100,33.3);
			var p=self.difference(((elems.Protein*4)/elems.Calories)*100,33.3);
			var f=self.difference(((elems.Fat*9)/elems.Calories)*100,33.3);
			return c+p+f;
		}

		//getMostProductive dato un valore (proteine, calorie, grassi ecc..)
		//ritornerà il vegetale più produttivo per l'elem passato espresso in g al mese
		//es: si vuol sapere le proteine? la funzione ti dirà che coltivando per un ciclo produttivo un metro quadro di soia (ad esempio) si otterranno tot grammi di proteine
		//Se l'elemeno che cerchiamo è proteine, il software selezionerà la soia
		this.getMostProductive=function(elem){
			var most=new Array("",0);
			for (var key_f in self.food) {
				var key_food=key_f;
				if(elem=="Protein" && key_food.toLowerCase().indexOf("soia")==-1)
					continue;
				
				//getFoodBalancing: un alimento che ha il 33,3% di grassi, proteine e carboidrati restituirà un indice 0
				//un alimento che ha il 90% di grassi, 5% proteine, 5% carboidrati restituirà un indice alto, ad esempio 80
				//la funzione è decommentata perchè non ha portato vantaggi allo script
				/*foodbalance=self.getFoodBalancing({
					"Calories":self.tofloat(self.food[key_food]["Calories"]),
					"Protein":self.tofloat(self.food[key_food]["Protein"]),
					"Fat":self.tofloat(self.food[key_food]["Fat"]),
					"Carbohydrate":self.tofloat(self.food[key_food]["Carbohydrate"])
				});
				if(foodbalance>50)
					continue;*/

				if(self.exclude.food[key_food]==1)
					continue;
				if(
					key_food.toLowerCase().indexOf("secch")!=-1 || 
					key_food.toLowerCase().indexOf("semi")!=-1 || 
					key_food.toLowerCase().indexOf("crema di")!=-1 || 
					key_food.toLowerCase().indexOf("crocchette di")!=-1 || 
					key_food.toLowerCase().indexOf("bucce di")!=-1 ||  
					key_food.toLowerCase().indexOf("amido di")!=-1 || 
					key_food.toLowerCase().indexOf("foglie di")!=-1 || 
					key_food.toLowerCase().indexOf("passata di")!=-1 || 
					key_food.toLowerCase().indexOf("farina di")!=-1 
				)
					continue;

				if(key_food.indexOf("Farina 0")!=-1 || key_food.indexOf("Farina 00")!=-1 || key_food.indexOf("Polenta")!=-1 || key_food.indexOf("Pasta")!=-1 || key_food.indexOf("Spaghetti")!=-1 || key_food.indexOf("Spaghetto")!=-1 || key_food.indexOf("Bulgur")!=-1 || key_food.indexOf("Crusca")!=-1 || key_food.indexOf("Kamut")!=-1 || key_food.indexOf("Cous cous")!=-1 || key_food.indexOf("triticale")!=-1 || key_food.indexOf("Farina integrale")!=-1 || key_food.indexOf("Semola")!=-1)
					key_food="Grano";
				else if(key_food.indexOf("Tempè")!=-1 || key_food.indexOf("Tofu")!=-1)
					key_food="Soia";
				else if(key_food.indexOf("malto")!=-1)
					key_food="Orzo perlato";
				else if(key_food.indexOf("Caldarroste")!=-1)
					key_food="Castagne secche";

				for (var key_r in self.rese) {
					var key_resa=key_r;
					if(key_resa.indexOf("Grano")!=-1)
						key_resa="Grano turco";

					if(key_food.indexOf(key_resa)!=-1){
						var resa=self.rese[key_resa].value;
						if(resa.indexOf("-")!=-1){
							resa=resa.split("-");
							resa=(parseInt(resa[0])+parseInt(resa[1]))/2;
						}
						resa=parseInt(resa);
						resa=self.convert_unit(resa,self.rese[key_resa].unit,"kg/mq");

						//i valori dentro food.json sono espressi in 100 grammi
						//quindi moltiplico per 10 in modo da avere il valore in kg
						//poi lo moltiplico per i kg che vengono prodotti in un mq
						resa=(self.tofloat(self.food[key_food][elem])*10)*resa;

						if(resa>most[1]){
							most[0]=key_food;
							most[1]=resa;
							most[2]=key_resa;
						}
					}
				}
			}
			return most;
		}

		this.convert_unit=function(val, unit_from, unit_to){
			val=self.tofloat(val);
			if(unit_from==unit_to){
				return val;
			}else if((unit_from=="g" && unit_to=="L") || (unit_from=="mg" && unit_to=="g")){
				return val*0.001;
			}else if((unit_from=="mg" && unit_to=="ug")){
				return val*1000;
			}else if((unit_from=="ug" && unit_to=="g")){
				return val*0.000001;
			}else if((unit_from=="t/ha" && unit_to=="kg/mq")){
				return (val*1000)/10000;
			}else if((unit_from=="q.li/ha" && unit_to=="kg/mq")){
				return (val*100)/10000;
			}
			return val;
		}

		this.merge_obj=function(ob1, ob2, op){
			for(key in ob2){
				if(key=="Calories" || key=="Protein" || key=="Fat" || key=="Carbohydrate")
					var new_val=self.convert_unit(ob2[key].replace(",","."),"","");
				else
					var new_val=self.convert_unit(ob2[key].replace(",","."),self.food.UNITS[key],self.gda[key].unit);
				if(typeof ob1[key] !== "undefined"){
					if(op=="+")
						ob1[key]+=new_val;
					else if(op=="-")
						ob1[key]-=new_val;
				}else
					ob1[key]=new_val;
			}
			return ob1;
		}
		
		this.shuffle=function(array){
			var currentIndex = array.length, temporaryValue, randomIndex ;

			// While there remain elements to shuffle...
			while (0 !== currentIndex) {
				// Pick a remaining element...
				randomIndex = Math.floor(Math.random() * currentIndex);
				currentIndex -= 1;

				// And swap it with the current element.
				temporaryValue = array[currentIndex];
				array[currentIndex] = array[randomIndex];
				array[randomIndex] = temporaryValue;
			}
			return array;
		}

		this.checkGda=function(gda, diet, listkeys){
			for(listkey in listkeys){
				key=listkeys[listkey];
			//for(key in diet){
				if(self.exclude.gda[key]==1)
					continue;

				//un ciclo produttivo dura mediamente 4 mesi quindi lo divido
				if((diet[key]/(30*4))<gda[key].value)
					return [key,"+"];
			}
			return true;
		}

		this.setBest = function(list, score){
			this.best = {"list":list,"score":score};
			fs.writeFileSync("best.json", JSON.stringify(this.best));
		}

		this.gda=this.getJson("../../gda.json");
		this.food=this.getJson("../../food.json");
		this.rese=this.getJson("../../rese.json");
		this.exclude=this.getJson("../../exclude.json");
		this.best=this.getJson("best.json");
	}

	var EV=new efficientVegetable();

	/*var button=$("#go");
	button.click(function(event){
		event.stopPropagation();
		main();
	});*/
	
	/*************************************************************************/
	var list_random=true;
	/*if(list_random){
		var countcmain=0;
		var cmain=0;
		var old_cmain=0;
		setInterval(function(){
			if(cmain==old_cmain && cmain>=1){
				countcmain++;
				if(countcmain>=3){
					countcmain=0;
					cmain=0;
					main();
				}
			}
			old_cmain=cmain;
		},5000);
	}*/
	
	for(var giri=0;;giri++){
		//get gda
		var gda=EV.gdaCalculate(gen,age,weight,height,activity,extra);

		//calcola i mq
		var new_diet={};
		var Mq={}, details={}, productives={};	

		var mp=EV.getMostProductive("Protein");
		productives["Protein"]=mp;
		
		//random list
		var listkeys=["Calcium", "Calories", "Carbohydrate", "Choline", "Copper", "Fat", "Iron", "Linoleic Acid", "Magnesium", "Pantothenic Acid", "Phosphorus", "Potassium", "Protein", "Selenium", "Sodium", "Thiamin", "Vitamin A", "Vitamin B 12", "Vitamin B 6", "Vitamin C", "Vitamin D", "Vitamin E", "Vitamin K", "Water", "Zinc", "α-LinolenicAcid"];
		
		//var listkeys=["Vitamin D", "Linoleic Acid", "Copper", "Water", "Vitamin K", "Zinc", "Selenium", "Protein", "Potassium", "Vitamin A", "Choline", "Vitamin E", "Sodium", "Carbohydrate", "Phosphorus", "Pantothenic Acid", "Calcium", "Fat", "α-LinolenicAcid", "Vitamin C", "Calories", "Thiamin", "Iron", "Magnesium", "Vitamin B 12", "Vitamin B 6"];
		
		if(list_random)
			listkeys=EV.shuffle(listkeys);
		
		new_diet=EV.merge_obj(new_diet, EV.food[mp[0]],"+");
		while(1){
			var check=EV.checkGda(gda, new_diet, listkeys);
			if(check===true){
				break;
			}else{
				if(typeof productives[check[0]] === "undefined"){
					var mp=EV.getMostProductive(check[0]);
					productives[check[0]]=mp;
				} else
					mp=productives[check[0]];
				new_diet=EV.merge_obj(new_diet, EV.food[mp[0]],check[1]);

				if(typeof Mq[mp[2]] === "undefined")
					Mq[mp[2]]=0;
				if(typeof details[mp[0]] === "undefined")
					details[mp[0]]=0;
				Mq[mp[2]]+=1;
			}
		}

		//show
		/*if(!list_random){
			$("#mq").html("");
			var tot=0;
			for (var key in Mq) {
				var detail="";
				for (var det in details)
					if(det.indexOf(key)!=-1)
						detail+=det+", ";

				tot+=Mq[key];
				$("#mq").append("<tr><td>"+key+" ("+detail+")</td><td>"+Mq[key]+"mq</td></tr>");
			}
			$("#mq").append("<tr><td><strong>Total</strong></td><td><strong>"+tot+"mq</strong></td></tr>");

			$("#gda").html("");
			for (var key in gda) {
				//un ciclo produttivo dura mediamente 4 mesi quindi lo divido
				$("#gda").append("<tr><td>"+key+"</td><td>"+Math.ceil(new_diet[key]/(30*4))+gda[key].unit+" (Gda: "+Math.ceil(gda[key].value)+")</td></tr>");
			}
		}*/
		if(list_random){
			var tot=0;
			for (var key in Mq)
				tot+=Mq[key];

			if(tot < EV.best.score){
				console.log(tot);
				EV.setBest(listkeys.join(),tot);
			}

			//load("http://localhost/orto/best_list.php?list="+encodeURIComponent(listkeys.join())+"&tot="+tot);
			//runCommand("/var/www/html/orto/best_list.sh", encodeURIComponent(listkeys.join())+" "+tot);
			/*$.ajax({
				url: "http://localhost/orto/best_list.php",
				method: "POST",
				async:false,
				data: { list : listkeys.join(), tot: tot },
				/*success:function(e){alert(JSON.stringify(e));},
				error:function(e){alert(JSON.stringify(e));}*//*
			});*/

			//cmain++;
			//button.click();
			//main();
		}
	}
	//main();
})();
