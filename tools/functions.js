function getXMLHttpRequest() {
    var xhr = null;
     
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        return null;
    }
     
    return xhr;
}

function tester(){
	var xhr=getXMLHttpRequest();
	var Vid2 = encodeURIComponent(document.getElementById('Vid').value);
	xhr.open("GET", "http://déclics.eu/projet/tools/usertest.php?login=" + Vid2, true);
	xhr.onreadystatechange=function()	{
		if(xhr.readyState==4 && (xhr.status==200 || xhr.status === 0)){
			if(xhr.responseText==1)	{
				document.getElementById("test").innerHTML="<font color=red><b>Le login "+document.getElementById("Vid").value+" est déjà utilisé</b></font>";
				document.getElementById("Vip").value="";
				}
			else
				{document.getElementById("test").innerHTML="<font color=red><b>c ok</b></font>";}
			}
		};
	xhr.send(null);
}


function recherche(){
	var valeur =document.getElementById('recherche').value;
	var xhr=getXMLHttpRequest();
	xhr.open("GET", "http://déclics.eu/projet/tools/autocompletion.php?valeur="+valeur, true);
	xhr.onreadystatechange=function()	{
		if(xhr.readyState==4 && (xhr.status==200 || xhr.status === 0)){
			if(xhr.responseText!= ' ')	
				//document.getElementById("autocomplete").value= xhr.responseText;
				document.getElementById("testeur").innerHTML= xhr.responseText;
			}
		};
	xhr.send(null);
}

function panier_udpdate(id_art,nbArticles,j){
	//document.getElementById("sp_prix").innerHTML= document.getElementById('souscateg'+v).value;
	var valeur =document.getElementById('souscateg'+j).value;
	var xhr=getXMLHttpRequest();
	xhr.open("GET", "http://déclics.eu/projet/tools/option_panier.php?id_art="+id_art+"&valeur2="+valeur, true);
	xhr.onreadystatechange=function()	{
		if(xhr.readyState==4 && (xhr.status==200 || xhr.status === 0)){
			if(xhr.responseText!= ' ')	{
				document.getElementById("sp_prix"+j).innerHTML= xhr.responseText;
				calcultotal(nbArticles);
				}
			}
		};
	xhr.send(null);
	
	
	}

function calcultotal(nbArticles){
	var total =0;
	var totalligne;
	for (var i=0; i<nbArticles; i++){ 
		totalligne=parseInt(document.getElementById('sp_prix'+i).innerHTML)*parseInt(document.getElementById('qte'+i).value);
		document.getElementById('sp_prixtotal'+i).innerHTML=totalligne;
		total+=totalligne;
		}
		
	document.getElementById("sp_total").innerHTML= total;	
	}


function valider(){

if(document.getElementById('Vprenom').value.length <= 3) {
    alert("Merci de vérifier le prénom" );   
	return false;
	}
	
else if(document.getElementById('Vnom').value.length <= 3) {
    alert("Saisissez le nom");
    return false;
	}
	
else if(document.getElementById('Vadress').value.length <= 3) {
    alert("Saisissez l'adresse");
    return false;
	}
	
else if(document.getElementById('Vcp').value.length != 5) {
    alert("Saisissez le code postal");
    return false;
	}

else if(document.getElementById('Vville').value.length <= 3) {
    alert("Saisissez la ville");
    return false;
	}

else if(document.getElementById('Vid').value.length <= 6) {
    alert("L'identifant doit faire minimum 6 caractères");
    return false;
	}

else if(document.getElementById('Vmp').length <= 6) {
    alert("Le mot de passe doit minimum 6 caractères");
    return false;
	}

else if(document.getElementById('Vmp2').value.length <= 6) {
    alert("Saisissez le deuxieme mot de passe");
    return false;
	}

else if(document.getElementById('Vmp').value !== document.getElementById('Vmp2').value){
    alert("Les deux mots de passe ne sont pas identiques");
    return false;
	}	
else if(document.getElementById('Vmail').value.length <= 8) {
    alert("Saisissez un email valide");
    return false;
	}
else if ((document.getElementById('Vmail').value.length > 8))
		{ if(bonmail(document.getElementById('Vmail').value) != "ok")
			{	alert("Saisissez un email valide");
				return false; 
			}
		}
else { return true;}

	
}
	
	

function bonmail(mailteste)

{
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');

	if(reg.test(mailteste))
	{
		return("ok");
	}
	else
	{
		return(false);
	}
}
