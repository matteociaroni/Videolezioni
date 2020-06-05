function coloraGiorni() //colora nella tabella le celle contenenti le date
{
	const tabella = document.getElementById("table").getElementsByTagName("td");
	let i = 0;
	for(i = 0; i < tabella.length; i++)
	{
		if(tabella[i].innerHTML == "In corso")
		{
			tabella[i].style.background = "#ff0300";
			tabella[i].style.color = "white";
		}
		if(tabella[i].innerHTML == "Oggi")
		{
			tabella[i].style.background = "#ff5400";
			tabella[i].style.color = "white";
		}
		if(tabella[i].innerHTML == "Domani")
		{
			tabella[i].style.background = "#ffbb00";
		}
	}
}

function coloraProf() //colora, nella tabella, le celle contenenti i prof
{
	const tabella = document.getElementById("table").getElementsByTagName("td");
	let i = 0;
	let cella;
	for(i = 0; i < tabella.length; i++)
	{
		cella = tabella[i].innerHTML;
		if(cella.includes("Inglese"))
		{
			tabella[i].style.background = "#ff00ff";
		}
		else if(cella.includes("Italiano") || cella.includes("Storia"))
		{
			tabella[i].style.background = "#ff8000";
		}
		else if(cella.includes("Sistemi") && cella.includes("TPS"))
		{
			const dimensione = 35;
			tabella[i].style.background = "repeating-linear-gradient(-45deg,#0000ff,#0000ff " + dimensione + "px,#ff80c0 " + dimensione + "px,#ff80c0 " + 2 * dimensione + "px)";
		}
		else if(cella.includes("Sistemi"))
		{
			tabella[i].style.background = "#0000ff";
		}
		else if(cella.includes("TPS"))
		{
			tabella[i].style.background = "#ff80c0";
		}
		else if(cella.includes("Matematica"))
		{
			tabella[i].style.background = "#ff0080";
		}
		else if(cella.includes("Telecomunicazioni"))
		{
			tabella[i].style.background = "#800080";
		}
		else if(cella.includes("Informatica"))
		{
			tabella[i].style.background = "#808000";
		}
		else if(cella.includes("Ripasso"))
		{
			tabella[i].style.background = "#3e3e3e";
		}
	}
}

function saveSelected() //salva in localstorage la classe selezionata dalla casella combinata
{
	if(typeof (Storage) !== "undefined")
	{
		localStorage.setItem("selected", document.getElementById("classe").value);
	}
}

function loadSelected() //restituisce dal localstorage la classe salvata
{
	if(typeof (Storage) !== "undefined")
	{
		return localStorage.getItem("selected");
	}
}

function select(classe) //imposta nella casella combinata come "selezionata" la classe salvata in localstorage
{
	if(classe == null)
		classe = loadSelected();
	var i = 0;

	var casella = document.getElementById("classe");

	for(i = 0; i < casella.length; i++)
	{
		if(casella.options[i].text == classe)
			casella.options[i].selected = true;
	}

}

function messaggio(materia, link) //restituisce un "alert" custom
{
	swal("Videolezione di " + materia + " in corso!", {
		buttons: {
			cancel: "Chiudi",
			catch: {
				text: "Apri link",
				value: "link",
			},
		},
	})
		.then((value) =>
		{
			if(value == "link")
			{
				window.open(link);
			}
		})

}

function dateUguali() //unisce le celle consecutive contenenti la stessa data
{
	const tabella = document.getElementById("table").getElementsByTagName("td");
	let i = 0, j = 0;
	let primaColonna = [];
	for(i = 3; i < tabella.length - 1; i += 3)
	{
		primaColonna.push(tabella[i]);
	}
	for(i = 0; i < primaColonna.length; i++)
	{
		j = 1;
		while(primaColonna[i].innerHTML == primaColonna[i + j].innerHTML)
		{
			primaColonna[i].rowSpan++;
			primaColonna[i + j].remove();
			j++;
		}
	}
}