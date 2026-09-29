function calcularPH(){

    let h = Number(document.getElementById("h").value);


    if(h <= 0){

        document.getElementById("resultadoPH").innerHTML =
        "Valor inválido";

        return;

    }


    let ph = -Math.log10(h);


    document.getElementById("resultadoPH").innerHTML =
    "pH = " + ph.toFixed(2);

}




function avaliarAgua(){

    let ph = Number(document.getElementById("phAgua").value);


    let resultado = "";


    if(ph < 6){

        resultado = "Água ácida - pode estar fora do ideal";

    }

    else if(ph >= 6 && ph <= 8.5){

        resultado = "Água adequada para consumo";

    }

    else{

        resultado = "Água alcalina - verificar qualidade";

    }


    document.getElementById("resultadoAgua").innerHTML = resultado;

}