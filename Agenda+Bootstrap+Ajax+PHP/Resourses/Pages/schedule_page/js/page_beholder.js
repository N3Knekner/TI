// Global Objects  ---------------------------------------------------------

	var BD = {
		"value" : "null",

		"all" : function(){
			var form = new FormData();
			form.append("Contacts","true");

			console.warn("Iniciado Dowload do BD");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
					value = JSON.parse(this.responseText);
					BD.value = value;
					console.log("Arquivos Baixados:");
					console.log(value);
					
					numberOfPages_v1 = Math.ceil(BD.value.length/16);
					numberOfPages_v2 = Math.ceil(BD.value.length/21);

					if (vision == 0) {vision_one()}
					else{vision_two()}
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
				
		},

		"safePages" : function(){ // Interditado! Apresentando erros de calculos
			var form = new FormData();
			form.append("Contacts","true");
			form.append("Stage", Stage );
			form.append("Vision", vision );

			console.warn("Iniciado Dowload do BD safe");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log(this.responseText);
					value = JSON.parse(this.responseText);
					BD.value = value;
					console.log("Arquivos Baixados:");
					console.log(value);
					insertInputs();
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"totalValue" : function(){

			numberOfPages_v1 = Math.ceil(BD.value.length/16);
			numberOfPages_v2 = Math.ceil(BD.value.length/21);

			setInformationOfPages();
				
		},


		"search" : function(string,filter,Class){
			var form = new FormData();
			form.append("Search", string);
			form.append("Class_Filter", Class);
			form.append("Type_Filter", filter);

			console.warn("Iniciado Pesquisa");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
					value = this.responseText;
					console.log("Arquivos Encontrados:");
					console.log(value);
					document.getElementById('results').innerHTML = "<text>Resultados Para Sua Pesquisa:</text><br>"+value;
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"edit" : function(obj){
			var inputs = obj.getElementsByTagName('input');
			
			var form = new FormData();
			form.append("Edit_Button", "true");

			form.append("Add_Nome", inputs[0].value);
			form.append("Add_Fone", inputs[1].value);
			form.append("Add_DataNasc", inputs[2].value);
			form.append("Add_Email", inputs[3].value);
			form.append("case", inputs[4].value);

			console.warn("Iniciado Atualização do Banco de Dados");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Status Final: "+this.responseText);
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"addNew" : function(bool){
			var form = new FormData();
			form.append("Add_Save", "true");

			var d= new Date();
			var dateSTR = (d.getFullYear() +"-"+ d.getMonth() +"-"+ d.getDate());

			form.append("Add_Nome", "Nome - "+BD.value.length);
			form.append("Add_Fone", "12345678");
			form.append("Add_DataNasc", dateSTR );
			form.append("Add_Email", "email@email.com");

			console.warn("Iniciado Atualização do Banco de Dados");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Status Final: "+this.responseText);
	            	BD.all();
	            	if (bool) {
	            		BD.totalValue();
	            	}
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"favorite" : function(obj){
			var inputs = obj.getElementsByTagName('input');
			
			var form = new FormData();
			form.append("Favorite_Button", "true");
			form.append("case", inputs[4].value);

			console.warn("Iniciado Atualização do Banco de Dados");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Status Final: "+this.responseText);
				}else{
					console.log("Erro ao estabelecer conexao");
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"remove" : function(obj){
			var form = new FormData();
			form.append("Delete_Button","true");
			form.append("case", obj.getElementsByTagName('input')[4].value);

			console.warn("Iniciado Alteracao do Banco de Dados");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Status Final: "+this.responseText);
	            	BD.all();
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"user" : function(set){
			var form = new FormData();
			form.append("Request_User","true");

			console.warn("Iniciado Requisição do usuário");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Foi detectado o user: "+this.responseText);
	            	set(this.responseText);
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"verify_birthday" : function(set){
			var form = new FormData();
			form.append("birthday","true");

			console.warn("Iniciado Aniversarios");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log("Foi encotrado: "+this.responseText);
	            	if (this.responseText != "nothing") bootbox.alert("Aniversáriantes: "+this.responseText);
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		},

		"logoff" : function(path){
			var form = new FormData();
			form.append("logoff","true");

			console.warn("Iniciado o requerimento: Saindo...");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location=path;
				}
			}
			xmlhttp.open("POST", "schedule_controller.php", true);
        	xmlhttp.send(form);
		}

	}

	var body = document.getElementsByTagName('body')[0];

	var bnt_home = document.getElementById('home');
	var bnt_profile = document.getElementById('bnt_profile');
	var UserName = document.getElementById('UserName');
	var letter_name = document.getElementById('letter_name');

	var profile_menu = document.getElementById('profile_menu');

	var cfg_resetSearchBar = document.getElementById("bnt_resetSearchBar");
	var bnt_resetSearchBarAndroid = document.getElementById('bnt_resetSearchBarAndroid');

	var cfg_toogleQuestion = document.getElementById('bnt_toogleQuestion');
	var bnt_toogleQuestionAndroid = document.getElementById('bnt_toogleQuestionAndroid');

	var cfg_logoff = document.getElementById('menu_logoff');
	var cfg_logoffAndOn = document.getElementById('menu_logoffAndOn');

	var schedule = document.getElementById('schedule');

	var tools = document.getElementById('tools');
	var tool_write = document.getElementById('tool_write');
	var tool_erase = document.getElementById('tool_erase');
	var tool_search = document.getElementById('tool_search');
	var tool_filter = document.getElementById('tool_filter');

	var search_bar = document.getElementById('search_bar');
	var search_text = document.getElementById('search_text');
	var search_filterText = document.getElementById('search_filterText');

	var tool_closeBar = document.getElementById('tool_closeBar');
	var tool_searchBar = document.getElementById('tool_searchBar');
	var tool_searchManualBnt = document.getElementById('tool_searchManualBnt');

	var filter_name  = document.getElementById('filter_name');
	var filter_mounth  = document.getElementById('filter_mounth');
	var filter_lastName  = document.getElementById('filter_lastName');
	var filter_firstName  = document.getElementById('filter_firstName');
	var filter_emailName  = document.getElementById('filter_emailName');
	var filter_emailDomain  = document.getElementById('filter_emailDomain');
	var filter_emailComplete  = document.getElementById('filter_emailComplete');

	var book = document.getElementById('book');
	var page = document.getElementById('page_Front');
	var page_verse = document.getElementById('page_Verse');

	var informationPages = document.getElementById('informationPages')

	var bnt_visionOne = document.getElementById('bnt-5');
	var bnt_visionTwo = document.getElementById('bnt-6');

	var c_ArrowBack = document.getElementById('c_ArrowBack');
	var c_ArrowForward = document.getElementById('c_ArrowForward');
// End             ---------------------------------------------------------

// Global Vars     ---------------------------------------------------------
	var totalContacts = 0;

	var numberOfPages_v1 = 1;
	var numberOfPages_v2 = 1;

	var book_Border = 10;
	var search_moving = false;

	var mouse_x = null;
	var mouse_y = null;

	var dist_x = 0;
	var dist_y = 0;

	var search_keepInitalState = true;

	var delete_Question = true;

	var showOptions = true;

	var cur = false;

	var edit_active = false;

	var vision = 0;

	var Stage = 1;

	var NameNumber = 0;

	var ctx_SAVE = null;

	const reducer = (accumulator, currentValue) => accumulator + currentValue;

					 /*["name"	,"phone"	,"email","date","inputlag"	,"favorite"	] */
	var inputTypes = [ ["100px"	,"70px"		,"100px","10px","5px"		,"10px"		]	,["100px","70px","100px","10px","5px","10px"]];

	var inputTextSize=[null,null];

	searchTimeout = 0;
// End             ---------------------------------------------------------

// Event Listeners ---------------------------------------------------------
	bnt_home.onclick = function(){window.open("../../../index.html");}
	bnt_profile.onclick = function(){profile_options(showOptions);}

	bnt_visionOne.onchange = function(){vision_one(true);};
	bnt_visionTwo.onchange = function(){vision_two();};

	tool_erase.onclick=function(){
		if(!edit_active){
			cur = !cur;
			if (cur  && !edit_active) {
				body.style.cursor = "url('img/eraser_black_cur.png') 0 25, pointer";
				schedule.classList.add("true_eraser");
			}else if(!edit_active){
				body.style.cursor = "auto";
				schedule.classList.remove("true_pen");
				schedule.classList.remove("true_eraser");
			}
		}
	};
	tool_write.onclick=function(){
		if(!edit_active){
		cur = !cur;
			if (cur) {
				body.style.cursor = "url('img/pen_black_cur.png') 0 32, pointer";
				schedule.classList.add("true_pen");
			}else{
				body.style.cursor = "auto";
				schedule.classList.remove("true_pen");
				schedule.classList.remove("true_eraser");
			}
		}
	};

	tool_search.onclick = function(){if(!edit_active){search_Filter(true);}};
	tool_closeBar.onclick = function(){search_Filter(false);};
	cfg_resetSearchBar.onclick = function(){toogle_resetSearchBar();};

	cfg_toogleQuestion.onclick=function(){toogle_DeleteQuestion();};

	cfg_logoff.onclick = function(){BD.logoff('../../../index.html');};
	cfg_logoffAndOn.onclick = function(){BD.logoff('../login/login.php');};


	filter_mounth.onclick = function(){search_setFilter("Mês",this.parentNode.getAttribute("type"))};
	filter_name.onclick = function(){search_setFilter("Nome Completo",this.parentNode.getAttribute("type"))};
	filter_lastName.onclick = function(){search_setFilter("Sobrenome",this.parentNode.getAttribute("type"))};	
	filter_firstName.onclick = function(){search_setFilter("Primeiro Nome",this.parentNode.getAttribute("type"))};
	filter_emailName.onclick = function(){search_setFilter("Nome do Email",this.parentNode.getAttribute("type"))};
	filter_emailComplete.onclick = function(){search_setFilter("Email Completo",this.parentNode.getAttribute("type"))};
	filter_emailDomain.onclick = function(){search_setFilter("Domínio  do Email",this.parentNode.getAttribute("type"))};

	tool_searchManualBnt.onclick = function(){showResults_search()};
	search_text.onkeyup = function(){
		if (searchTimeout == 0) {
			setTimeout(function(){
				showResults_search();
				searchTimeout = 0;
			}, 600);
		}
		searchTimeout++;
	};

	c_ArrowBack.onclick = function(){if (edit_active) {
			bootbox.alert("Não esqueça de terminar de editar!");
		}else{if (Stage != 1)Stage--; insertInputs(); setInformationOfPages();}}
	c_ArrowForward.onclick = function(){if (edit_active) {
			bootbox.alert("Não esqueça de terminar de editar!");
		}else{let n = vision == 1 ? numberOfPages_v2 : numberOfPages_v1; let m = vision == 1 ? 21 : 16; if (Stage != n){Stage++; insertInputs(); setInformationOfPages();} else if (n == Stage && BD.value.length == Stage * m) {BD.addNew(true);} if (n == Stage){spawn_Arrows("#f8f9fa");}};
	}

	c_ArrowBack.onmouseover = function(){spawn_Arrows("#f8f9fa");}
	c_ArrowForward.onmouseover = function(){spawn_Arrows("#f8f9fa");}
	c_ArrowBack.onmouseout = function(){spawn_Arrows("#DDD");}
	c_ArrowForward.onmouseout = function(){spawn_Arrows("#DDD");}

// End             ---------------------------------------------------------

// Load            =========================================================
	BD.user(function(a){if (a != "false") {UserName.innerHTML = a;letter_name.innerHTML = a.substring(0,1);}else{alert("É necessario logar-se para acesssar a agenda");window.location = "../login/login.php";}});
	BD.totalValue();
	BD.all();
	vision_one(false);
	spawn_Arrows("#DDD");
	set_searchBarPosition(schedule.clientWidth/2-200,window.innerHeight/100*20);
	drag_div("search_bar");
	BD.verify_birthday();

// End             =========================================================

// Functions       ---------------------------------------------------------


	function vision_one(bool){
		if (edit_active) {
			bootbox.alert("Não esqueça de terminar de editar!");
		}else{
		vision = 0;
		if (bool) {
			schedule.removeChild(page);
			schedule.appendChild(book);
			book.appendChild(page);
		}
		schedule.style.height="80vh";
		page.style.marginTop = "0px";

		if (Stage > numberOfPages_v1){ Stage = numberOfPages_v1;}
		
		var window_sizeY = schedule.clientHeight;
		var window_sizeX = schedule.clientWidth;

		var book_sizeY = window_sizeY;
		var book_sizeX = Math.round(book_sizeY/29.7*21)*2+book_Border;

		var page_sizeY = window_sizeY - book_Border/2; // window_sizeY - margin value;
		var page_sizeX = Math.round(page_sizeY/29.7*21); //A4 resolution

		var percent = (page_sizeX-36)/100;

		inputTypes[0]=[Math.floor(percent*30),Math.floor(percent*20),Math.floor(percent*13),Math.floor(percent*23),Math.floor(percent*5),Math.floor(percent*5)];

		inputTextSize[0] =Math.floor((page_sizeY-45)/100*6);

		page.style.height = page_sizeY+"px";
		page.style.width = page_sizeX+"px";
		page.style.boxShadow = "none";
		page.style.marginLeft = "0px";
		page.style.paddingTop = "5px";
		page.style.paddingLeft = (page_sizeX-inputTypes[0].reduce(reducer)-36)/2+"px";
		page.style.paddingRight = (page_sizeX-inputTypes[0].reduce(reducer)-36)/2+"px";

		page_verse.style.height = page_sizeY+"px";
		page_verse.style.width = page_sizeX+"px";
		page_verse.style.paddingTop = "5px";
		page_verse.style.paddingLeft = (page_sizeX-inputTypes[0].reduce(reducer)-36)/2+"px";
		page_verse.style.paddingRight = (page_sizeX-inputTypes[0].reduce(reducer)-36)/2+"px";
		book.style.paddingLeft = (book_sizeX-page_sizeX*2)/2+"px";

		book.style.height = book_sizeY+"px";
		book.style.width = book_sizeX+"px";
		book.style.marginLeft = (window_sizeX-book_sizeX)/2+"px";


		try{insertInputs();}
		catch(e){}
		}

		setInformationOfPages();
	}

	function vision_two(){
		if (edit_active) {
			bootbox.alert("Não esqueça de terminar de editar!");
		}else{
		vision=1;
		try{
		schedule.removeChild(book);
		schedule.appendChild(page);
		}
		catch(e){}

		if (Stage > numberOfPages_v2) Stage = numberOfPages_v2;

		var window_sizeY = window.innerHeight/100*80;
		var window_sizeX = schedule.clientWidth;
	
		var book_sizeX = Math.round(window_sizeY/29.7*21)*2+book_Border;

		var page_sizeX = book_sizeX;
		var page_sizeY = Math.round(page_sizeX/21*29.7); //A4 resolution

		var percent = (page_sizeX-36)/100;

		inputTypes[1]=[Math.floor(percent*32),Math.floor(percent*13),Math.floor(percent*17),Math.floor(percent*28),Math.floor(percent*3),Math.floor(percent*3)];

		inputTextSize[1] =Math.floor((page_sizeY-60)/100*4.5);

		page.style.height = page_sizeY+"px";
		page.style.width = page_sizeX+"px";
		page.style.boxShadow = "0px 0px 10px black";
		page.style.marginLeft = (window_sizeX-page_sizeX)/2 +"px";
		page.style.marginTop = "10px";
		page.style.paddingTop = "10px";
		page.style.paddingLeft = (page_sizeX-inputTypes[1].reduce(reducer)-36)/2+"px";
		page.style.paddingRight = page.style.paddingLeft;

		schedule.style.height=page_sizeY+20+"px";

		setInformationOfPages();
		
		try{insertInputs();}
		catch(e){}
		}
	}

	function spawn_Arrows(n){

		if (c_ArrowBack.getContext) {
			let ctx = c_ArrowBack.getContext('2d');

			ctx.beginPath();
			ctx.moveTo(50,500);
			ctx.lineTo(125,350);
			ctx.lineTo(200,350);
			ctx.lineTo(125,500);
			ctx.lineTo(200,650);
			ctx.lineTo(125,650);
			ctx.fillStyle = n;
			ctx.fill();
		}
		if (c_ArrowForward.getContext) {
			ctx_SAVE = c_ArrowForward.getContext('2d');

			ctx_SAVE.clearRect(0,0,250,1000);
			
			ctx_SAVE.beginPath();
			ctx_SAVE.moveTo(200,500);
			ctx_SAVE.lineTo(125,350);
			ctx_SAVE.lineTo(55,350);
			ctx_SAVE.lineTo(125,500);
			ctx_SAVE.lineTo(55,650);
			ctx_SAVE.lineTo(125,650);

			ctx_SAVE.fillStyle = n;
			ctx_SAVE.fill();
				

			if ((vision == 1 ? numberOfPages_v2 : numberOfPages_v1) == Stage && BD.value.length == Stage * (vision == 1 ? 21 : 16) && n == "#f8f9fa") {

				ctx_SAVE.clearRect(0,0,250,1000);

				ctx_SAVE.beginPath();

				ctx_SAVE.moveTo(100,400);
				ctx_SAVE.lineTo(150,400);

				ctx_SAVE.lineTo(150,475);

				ctx_SAVE.lineTo(225,475);
				ctx_SAVE.lineTo(225,525);

				ctx_SAVE.lineTo(150,525);

				ctx_SAVE.lineTo(150,600);
				ctx_SAVE.lineTo(100,600);

				ctx_SAVE.lineTo(100,525);

				ctx_SAVE.lineTo(25,525);
				ctx_SAVE.lineTo(25,475);

				ctx_SAVE.lineTo(100,475);

				ctx_SAVE.fillStyle = n;
				ctx_SAVE.fill();
			}
			
		}
		
	}

	function setInformationOfPages(){
		var k = "Error: Not Found";
		if (vision == 0) {
			k = numberOfPages_v1;
		}else {
			k = numberOfPages_v2;
		}
		informationPages.innerHTML = "Página "+ Stage +" de "+  k; 
	}


	function showResults_search(){
		BD.search(search_text.value,search_filterText.innerHTML,search_filterText.getAttribute("type"));
	}

	function setWidth_inputs(){
		var n = vision;
		var inputs = document.getElementsByClassName('input');
		var c = -1;
		for (var i = 0; i < inputs.length; i++) {
			c++
			if (c == 6) {c = 0;}
			inputs[i].style.width = inputTypes[n][c]+"px";
			inputs[i].style.height = inputTextSize[n]+"px";
		}
	}

	function insertInputs(){
		page.innerHTML = " ";
		page_verse.innerHTML = " ";
		var multiply = vision == 1 ? 21 : 16;
		var cLines = 0;

		//normal page

		for (var i = (Stage-1) * multiply; i < (Stage * multiply > BD.value.length-1 ? BD.value.length :  Stage * multiply); i++) {
			cLines++;
			var div = document.createElement("div");
			div.className = "row mx-0 line";
			page.appendChild(div);
			for (var c = 0; c < 6; c++) {
				let input = document.createElement("input");
				if (c==3) {
					input.setAttribute('type', 'email');
				}else if (c==2) {
					input.setAttribute('type', 'date');
				}else if(BD.value[i][c] == "★"){
					input.classList.add("fav");
				}else if (!isNaN(BD.value[i][c])) {
					input.classList.add("tel");
				}
				else{
					input.setAttribute('type', 'text');
				}
				input.setAttribute('disabled', 'disabled');
				input.setAttribute('value', BD.value[i][c]);
				input.style.width = inputTypes[0][c];
				input.classList.add("input");
				div.appendChild(input);
			}
			div.onclick = function(){
				if (schedule.classList.contains("true_eraser")) {
					if (BD.value.length != 1) {
						if (!delete_Question) {
							var div =this;
							
							bootbox.confirm({
								message: "Deseja exluir o contato?",
								buttons: {
									confirm: {
										label: 'Sim',
										className: 'btn-primary'
									},
									cancel: {
										label: 'Não',
										className: 'btn-light'
									}
								},
								callback: function (result) {
									if (result) {BD.remove(div);}
								}
							});
						}
						else{
							BD.remove(this);
						}
					}else{
						bootbox.alert("Não é possível exluir o primeiro contato");
					}
		
				}else if (cur && !edit_active) {

					edit_active=true;

					let bnt3 = this.getElementsByTagName('input')[5];
					console.log(bnt3);

					let bnt2 = document.createElement("div");
					bnt2.className = "bnt-apply btn btn-danger";
					bnt2.innerHTML = "<text>Cancelar</text>"

					let bnt = document.createElement("div");
					bnt.className = "bnt-apply btn btn-primary";
					bnt.innerHTML = "<text>Aplicar</text>"
					/*this.style.border="2px solid lightblue";*/

					bnt.onclick = function(){
						BD.edit(this.parentNode);
						finishEdit(this);
					}
					bnt2.onclick = function(){
						finishEdit(this);
					}
					bnt3.onclick = function(){
						BD.favorite(this.parentNode);
						finishEdit(bnt);
					}

					this.appendChild(bnt);
					this.appendChild(bnt2);

					var inputs = this.getElementsByTagName("input");
					for (var w = 0; w < 4; w++) {
						inputs[w].removeAttribute('disabled');
					}
					inputs[5].removeAttribute('disabled');
				}
			}
		}
		
		if (cLines != multiply) {
			var div = document.createElement("div");
			div.style.width = "100%";
			div.style.height = "50%";
			div.className= "addingDiv" ;
			div.onclick = function() {
				if (edit_active) {
					bootbox.alert("Não esqueça de terminar de editar!");
				}else{BD.addNew(false);}
			}
			page.appendChild(div);

			page.style.display = "flex";
			page.style.flexDirection = "column";

			div.style.flexGrow = "1";

			var canvas = document.createElement("canvas");
			canvas.width = "500";
			canvas.height = "500";
			canvas.style.width = "auto";
			canvas.style.height = "30%";
			canvas.style.left = "50%";
			canvas.style.top = "50%";
			canvas.style.marginRight = "-50%";
			canvas.style.marginTop = "-50%";
			canvas.style.transform = "translate(-50%, -50%)";
			canvas.style.position = "relative";

			div.appendChild(canvas);

			ctx = canvas.getContext('2d');

			ctx.beginPath();

			ctx.moveTo(200,0);
			ctx.lineTo(300,0);

			ctx.lineTo(300,200);

			ctx.lineTo(500,200);
			ctx.lineTo(500,300);

			ctx.lineTo(300,300);

			ctx.lineTo(300,500);
			ctx.lineTo(200,500);

			ctx.lineTo(200,300);

			ctx.lineTo(0,300);
			ctx.lineTo(0,200);

			ctx.lineTo(200,200);

			ctx.fillStyle = "#f8f9fa";

			ctx.fill();

			c_ArrowForward.remove();
		}else{
			schedule.appendChild(c_ArrowForward);
		}

		// page verse
		var previousStage=Stage-1;
		if (previousStage != 0) {

		for (var i = (previousStage-1) * multiply; i < (previousStage * multiply > BD.value.length-1 ? BD.value.length :  previousStage * multiply); i++) {
			var div = document.createElement("div");
			div.className = "row mx-0 line";
			page_verse.appendChild(div);
			for (var c = 0; c < 6; c++) {
				let input = document.createElement("input");
				if (c==3) {
					input.setAttribute('type', 'email');
				}else if (c==2) {
					input.setAttribute('type', 'date');
				}else{
					input.setAttribute('type', 'text');
				}
				input.setAttribute('disabled', 'disabled');
				input.setAttribute('value', BD.value[i][c]);
				input.style.width = inputTypes[0][c];
				input.className = "input line-"+i;
				div.appendChild(input);
			}
			div.onclick = function(){
				if (schedule.classList.contains("true_eraser")) {

					if (!delete_Question) {
						var div =this;
						
						bootbox.confirm({
							message: "Deseja exluir o contato?",
							buttons: {
								confirm: {
									label: 'Sim',
									className: 'btn-primary'
								},
								cancel: {
									label: 'Não',
									className: 'btn-light'
								}
							},
							callback: function (result) {
								if (result) {BD.remove(div);}
							}
						});
					}
					else{
						BD.remove(this);
					}
		
				}else if (cur && !edit_active) {

					edit_active=true;

					let bnt3 = this.getElementsByTagName('input')[5];
					console.log(bnt3);

					let bnt2 = document.createElement("div");
					bnt2.className = "bnt-apply btn btn-danger";
					bnt2.innerHTML = "<text>Cancelar</text>"

					let bnt = document.createElement("div");
					bnt.className = "bnt-apply btn btn-primary";
					bnt.innerHTML = "<text>Aplicar</text>"

					bnt.onclick = function(){
						BD.edit(this.parentNode);
						finishEdit(this);
					}
					bnt2.onclick = function(){
						finishEdit(this);
					}
					bnt3.onclick = function(){
						BD.favorite(this.parentNode);
						finishEdit(bnt);
					}

					this.appendChild(bnt);
					this.appendChild(bnt2);

					var inputs = this.getElementsByTagName("input");
					for (var w = 0; w < 4; w++) {
						inputs[w].removeAttribute('disabled');
					}
					inputs[5].removeAttribute('disabled');
				}
			}
		}
	}

		setWidth_inputs(vision);
	}

	function finishEdit(b){
		var div = b.parentNode;
		var bnt2 = b;
		if (div.getElementsByClassName('btn')[0] !=  bnt2) {
			var bnt1 = div.getElementsByClassName('btn')[0];
		}else{
			var bnt1 = div.getElementsByClassName('btn')[1];
		}

		for (var i = 0; i < div.getElementsByTagName('input').length; i++) {
			div.getElementsByTagName('input')[i].setAttribute('disabled', 'disabled');
		}

		var time = 10;
		var fade = setInterval(function(){time--;bnt2.style.opacity=time/10;bnt1.style.opacity=time/10;if(time == 0){clearInterval(fade);a();}},25);

		function a(){
			edit_active = false;	
			div.removeChild(bnt1);
			div.removeChild(bnt2);
			BD.all();
		}
	}

	function toogle_DeleteQuestion(){

		if (delete_Question) {
			bnt_toogleQuestionAndroid.className = "true";
			time = 0;
			var fade = setInterval(function(){console.log(time);bnt_toogleQuestionAndroid.value = time;if(time == 10){clearInterval(fade);a();}time++;},10);
		}else{
			bnt_toogleQuestionAndroid.className = "false";
			time = 10;
			var fade = setInterval(function(){console.log(time);bnt_toogleQuestionAndroid.value = time;if(time == 0){clearInterval(fade);a();}time--;},10);
		}
		function a(){
			delete_Question = !delete_Question;
		}

	}

	function toogle_resetSearchBar(){
		if (search_keepInitalState) {
			bnt_resetSearchBarAndroid.className = "true";
			time = 0;
			var fade = setInterval(function(){console.log(time);bnt_resetSearchBarAndroid.value = time;if(time == 10){clearInterval(fade);a();}time++;},10);
		}else{
			bnt_resetSearchBarAndroid.className = "false";
			time = 10;
			var fade = setInterval(function(){console.log(time);bnt_resetSearchBarAndroid.value = time;if(time == 0){clearInterval(fade);a();}time--;},10);
		}
		function a(){
			search_keepInitalState = !search_keepInitalState;
		}
	}
	function search_Filter(bool) {
		if (bool) {
			if (search_keepInitalState){
				set_searchBarPosition(schedule.clientWidth/2-200,window.innerHeight/100*20);
			}

			tools.classList.add("justify-content-center");
			tool_write.setAttribute("hidden","hidden");
			tool_search.setAttribute("hidden","hidden");
			tool_erase.setAttribute("hidden","hidden");
			tool_filter.removeAttribute("hidden");
			search_bar.removeAttribute("hidden");
			tool_searchBar.className = "col-5 no-gutters tool";

			var time = 0;
			var fade = setInterval(function(){time++;search_bar.style.opacity=time/100;if(time == 100){clearInterval(fade);}},2);
		
		}else{
			var time = 100;
			var fade = setInterval(function(){time--;search_bar.style.opacity=time/100;if(time == 0){clearInterval(fade);a();}},2);
			
			tools.classList.remove("justify-content-center");
			tool_write.removeAttribute("hidden");
			tool_search.removeAttribute("hidden");
			tool_erase.removeAttribute("hidden");
			tool_filter.setAttribute("hidden","hidden");
			tool_searchBar.className = "col-1_5 no-gutters bnt-advanced tool";

			function a(){search_bar.setAttribute("hidden","hidden");}
		
		}
	}
	
	function search_setFilter(selected,type){
		search_filterText.innerHTML = selected;
		search_filterText.setAttribute("type",type);
	}

	
	function drag_div(div_id){
		var div;

		div = document.getElementById(div_id);

		div.addEventListener('mousedown', function(e) {
			div.isDown = true;
			div.offset = [
			div.offsetLeft - e.clientX,
			div.offsetTop - e.clientY
			];
		}, true);

		div.addEventListener('mouseup', function() {
			div.isDown = false;
		}, true);

		div.addEventListener('mousemove', function(event) {
			event.preventDefault();
			if (div.isDown) {
				div.mousePosition = {

					x : event.clientX,
					y : event.clientY

				};
				div.style.left = (div.mousePosition.x + div.offset[0]) + 'px';
				div.style.top  = (div.mousePosition.y + div.offset[1]) + 'px';
			}
		}, true);
	}

	function set_searchBarPosition(x,y){
		search_bar.style.top = y+"px";
		search_bar.style.left = x+"px";
	}
	

	function profile_options(bool) {
		if (bool) {
			profile_menu.classList.add("show");
			var time = 0;
			var fade = setInterval(function(){time++;profile_menu.style.opacity=time/100;if(time == 100){clearInterval(fade);}},2);
		
		}else{
			var time = 100;
			var fade = setInterval(function(){time--;profile_menu.style.opacity=time/100;if(time == 0){clearInterval(fade);profile_menu.classList.remove("show");;}},2);
		}
		showOptions = !showOptions;
	}

	function moveToPage(obj){
		let m = vision == 1 ? 21 : 16;
		Stage = Math.ceil((parseInt(obj.getElementsByClassName("search_case")[0].innerHTML)+1)/m);
		setInformationOfPages();
		insertInputs();
	}

// End             ---------------------------------------------------------

