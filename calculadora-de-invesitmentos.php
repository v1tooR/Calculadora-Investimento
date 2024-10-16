<?php

/*
Plugin: Calculadora de Investimentos
Criado em: 10/10/2024
*/

if(!defined('ABSPATH')){
    exit;
}

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Investimentos</title>
    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        
        body {
            font-family: Montserrat;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            color: #FFFFFF;
            padding: 20px;
        }

        .calculator {
            width: 100%;
            max-width: 100%;
            padding: 20px 20px 5px 20px;
            border-radius: 20px;
            background-color: #E6E6E6;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #FFFFFF;
            margin-top: 10px;
        }

        .calculator h1 {
            color: #242424;
            font-size: 33px;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: start;
        }

        .form-group {
            margin-top: 10px;
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 100%;
            gap: 14px; /* Adiciona ou ajusta o valor de gap */
        }

        label {
            margin-top: 10px;
            color: #FFFFFF;
            font-size: 14px;
        }

        input {
            font-family: Montserrat;
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            background-color: #FFFFFF;
            color: #000000;
            border: none;
            border-radius: 10px;
            font-size: 14px;
        }

        input#investmentTime,#interestRate{
            width: 31%;
        }

        select {
            font-family: Montserrat;
            width: auto;
            padding: 9px;
            margin-top: 5px;
            box-sizing: border-box;
            background-color: #FFFFFF;
            color: #00008B;
            border-radius: 10px;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            width: 100%; /* Ajuste a largura dos botões */
        }

        button {
            font-family: Montserrat;
            width: 100%;
            margin-top: 5px;
            padding: 11px;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }

        #calcular{
            background-color: #00008B;
            text-transform: uppercase;
        }

        #calcular:hover{
            background-color: #7DB667;
            transition: 0.2s;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        button:focus {
            outline: none;
        }

        #clearButton {
            background-color: #E6E6E6;
            color: #242424;
            margin-left: 4%;
        }

        .results {
            margin-top: 20px;
            width: 100%;
            max-width: 1200px;
        }

        .values {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            border-radius: 20px;
            background-color: #E6E6E6;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #242424;
            text-align: center;
            font-size: 16px;
            font-weight: 500;
        }

        #monthlyBreakdown {
            margin-top: 20px;
            overflow-x: auto;
            border-radius: 30px;
            border: 2px solid #7DB667;
        }

        #breakdownTable {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF;
            color: #7DB667;
            border-radius: 30px;
        }

        .chart-container {
            background-color: #FFFFFF;
            border: 2px solid #7DB667;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            color: #FFFFFF;
            margin-top: 20px;
            width: 100%;
            max-width: 100%;
        }

        .charts-container {
            display: flex;
            gap: 20px;
            justify-content: space-between;
        }

        .line-chart-container, .pie-chart-container {
            width: 100%;
            max-width: 100%;
            height: 400px;
        }

        #breakdownTable th, #breakdownTable td {
            border: 1px solid #7DB667;
            border-radius: 30px;
            padding: 18px;
            text-align: center;
            color: #000000;
        }

        .tab {
            overflow: hidden;
            border-bottom: 1px solid #ccc;
            width: 100%;
            margin-top: 20px;
        }

        .tab button {
            background-color: inherit;
            justify-content: center;
            margin: 5px;
            width: 49%;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            background-color: #7DB667;
            color: white;
        }

        .tab button:hover {
            background-color: #00008B;
            color: white;
        }

        .tab button.active {
            background-color: #00008B;
            color: white;
        }

        .tabcontent {
            display: none;
            border-top: none;
        }

        .tabcontent.active {
            display: block;
        }

        @media (max-width: 600px) {
            .calculator {
                width: 100%;
                padding: 15px;
            }

            button {
                padding: 8px;
                font-size: 14px;
            }

            .form-group {
                flex-direction: column;
            }

            input, select {
                padding: 6px;
                font-size: 14px;
            }

            .chart-container {
                width: 100%;
            }

            .charts-container {
                flex-direction: column;
                justify-content: column;
                gap: 10px;
            }

            .values {
                width: 100%;
            }

            .tab button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    </head>
    <body>
        <div class="calculator">
            <h1>Calculadora de Investimento</h1>
            <div class="form-group">
                <input type="text" id="initialAmount" placeholder="Aporte Inicial (R$):" oninput="applyCurrencyMask(this)">
                <input type="number" placeholder="Tempo de Investimento" id="investmentTime">
                <select id="timeUnit">
                    <option value="months">Meses</option>
                    <option value="years">Anos</option>
                </select>
                <input type="number" placeholder="Taxa de Juros (%)" id="interestRate">
                <select id="rateType">
                    <option value="monthly">Mensal</option>
                    <option value="annual">Anual</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="text" class="aportemensal" id="monthlyAmount" placeholder="Aporte Mensal (R$)" oninput="applyCurrencyMask(this)">
                <div class="button-group">
                    <button id="calcular" onClick="calculate()">Calcular</button>
                    <button id="clearButton" onClick="clearFields()">Limpar</button>    
                </div>
            </div>
            
            <p style="text-align: center; font-size: 0.9em; color: #888;">Feito pela MonqueiTech</p>
        </div>
    
        <div id="banner" style="display: none; text-align: center; margin-top: 20px;">
            <a href="https://example.com">
                <img src="https://via.placeholder.com/1228x400.png?text=Banner+1228x400" alt="Banner">
            </a>
        </div>
    
        <div class="values">
            <div id="finalValue"></div>
            <div id="totalInvested"></div>
            <div id="totalInterest"></div>
        </div>
    
        <div class="results" id="resultsDiv" style="display: none;">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Table')" id="defaultTab">Tabela</button>
                <button class="tablinks" onclick="openTab(event, 'Charts')">Gráficos</button>
            </div>
    
            <div id="Table" class="tabcontent">
                <div id="monthlyBreakdown">
                    <table id="breakdownTable">
                        <thead>
                            <tr>
                                <th>Mês</th>
                                <th>Aporte</th>
                                <th>Rendimento</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
    
            <div id="Charts" class="tabcontent">
                <div class="charts-container">
                    <div class="chart-container line-chart-container">
                        <canvas id="investmentChart" width="600" height="400"></canvas>
                    </div>
                    <div class="chart-container pie-chart-container">
                        <canvas id="pieChart" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function simulateRates() {
            return {
                inflationRate: 0.045,  // Taxa de inflação atualizada
                /*cdbRate: 11.0,  // Taxa do CDB atualizada
                dollarRate: 0.75,  // Taxa do dólar atualizada
                savingsRate: 0.25  // Taxa da poupança atualizada*/
            };
        }

        function formatCurrency(value) {
            return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/\D/g, '')) / 100;
        }

        function clearFields() {
            document.getElementById('initialAmount').value = '';
            document.getElementById('monthlyAmount').value = '';
            document.getElementById('investmentTime').value = '';
            document.getElementById('timeUnit').value = 'months';
            document.getElementById('interestRate').value = '';
            document.getElementById('rateType').value = 'monthly';
            document.getElementById('finalValue').innerText = '';
            document.getElementById('totalInvested').innerText = '';
            document.getElementById('totalInterest').innerText = '';
            document.querySelector('#breakdownTable tbody').innerHTML = '';
            document.getElementById('resultsDiv').style.display = 'none';
        }

        function applyCurrencyMask(element) {
            let value = element.value.replace(/\D/g, '');
            value = (parseInt(value) / 100).toFixed(2);
            element.value = formatCurrency(parseFloat(value));
            checkBannerDisplay();
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById('bannerModal').style.display = 'none';
        }

        async function calculate() {

            const initialAmountElement = document.getElementById('initialAmount');
            const monthlyAmountElement = document.getElementById('monthlyAmount');
            const interestRateElement = document.getElementById('interestRate');
            const investmentTimeElement = document.getElementById('investmentTime');

            if (!initialAmountElement.value || !monthlyAmountElement.value || !interestRateElement.value || !investmentTimeElement.value) {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            //clearGraphsAndTable();

            const initialAmount = parseCurrency(document.getElementById('initialAmount').value);
            const monthlyAmount = parseCurrency(document.getElementById('monthlyAmount').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value);
            const rateType = document.getElementById('rateType').value;
            const investmentTime = parseFloat(document.getElementById('investmentTime').value);
            const timeUnit = document.getElementById('timeUnit').value;

            const { inflationRate } = simulateRates(); //adicionar novos índices

            let months = timeUnit === 'years' ? investmentTime * 12 : investmentTime;
            let monthlyRate = rateType === 'annual' ? (interestRate / 100) / 12 : interestRate / 100;
            let monthlyInflationRate = inflationRate / 12;
            //let monthlyCdbRate = cdbRate / 12;
           //let monthlyDollarRate = dollarRate / 12;

            let totalInvested = initialAmount;
            let totalInterest = 0;
            let totalAmount = initialAmount;
            //let savingsTotal = initialAmount;
            //let savingsData = [];
            let breakdownHTML = '';
            let monthlyData = [];
            let aporteData = [];
            let rendimentoData = [];
            //let cdbData = [];
            let inflationData = [];
            //let dollarData = [];
            //let cdbTotal = initialAmount;
            //let inflationTotal = initialAmount;
            //let dollarTotal = initialAmount;

            for (let i = 0; i < months; i++) {
                totalAmount += monthlyAmount;
                totalInvested += monthlyAmount;
                let interest = totalAmount * monthlyRate;
                totalInterest += interest;
                totalAmount += interest;

                breakdownHTML += `<tr>
                    <td>${i + 1}</td>
                    <td>${formatCurrency(monthlyAmount)}</td>
                    <td>${formatCurrency(interest)}</td>
                    <td>${formatCurrency(totalAmount)}</td>
                </tr>`;

                monthlyData.push(i + 1);
                aporteData.push(totalInvested);
                rendimentoData.push(totalAmount);
                inflationData.push(totalInterest);
            }

            /*for (let i = 0; i < months; i++) {
                savingsTotal += monthlyAmount * (1 + savingsRate / 100);
                savingsData.push(savingsTotal.toFixed(2));
                totalAmount += monthlyAmount;
                totalInvested += monthlyAmount;
                let interest = totalAmount * monthlyRate;
                totalInterest += interest;
                totalAmount += interest;

                cdbTotal += monthlyAmount + (cdbTotal * monthlyCdbRate);
                inflationTotal += monthlyAmount + (inflationTotal * monthlyInflationRate);
                dollarTotal += monthlyAmount + (dollarTotal * monthlyDollarRate);

                breakdownHTML += `<tr>
                    <td>${i + 1}</td>
                    <td>${formatCurrency(monthlyAmount)}</td>
                    <td>${formatCurrency(interest)}</td>
                    <td>${formatCurrency(totalAmount)}</td>
                </tr>`;

                monthlyData.push(i + 1);
                aporteData.push(monthlyAmount);
                rendimentoData.push(interest);
                cdbData.push(cdbTotal.toFixed(2));
                inflationData.push(inflationTotal.toFixed(2));
                dollarData.push(dollarTotal.toFixed(2));
            }*/

            document.getElementById('finalValue').innerText = `Valor Total Final: ${formatCurrency(totalAmount)}`;
            document.getElementById('totalInvested').innerText = `Total Investido: ${formatCurrency(totalInvested)}`;
            document.getElementById('totalInterest').innerText = `Total de Juros: ${formatCurrency(totalInterest)}`;
            document.querySelector('#breakdownTable tbody').innerHTML = breakdownHTML;

            document.getElementById('resultsDiv').style.display = 'block';

            new Chart(document.getElementById('investmentChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthlyData,
                    datasets: [
                        {
                            label: 'Valor Total Investido',
                            data: aporteData,
                            borderColor: '#7DB667',
                            borderWidth: 1,
                            fill: false
                        },
                        {
                            label: 'Valor Total Final',
                            data: rendimentoData,
                            borderColor: 'green',
                            borderWidth: 1,
                            fill: false
                        },
                        {
                            label: 'Total de Juros',
                            data: inflationData,
                            borderColor: 'black',
                            borderWidth: 1,
                            fill: false
                        },
                        /*{
                            label: 'Inflação',
                            data: inflationData,
                            borderColor: 'red',
                            borderWidth: 1,
                            fill: false
                        }*/
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Mês'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Valor (R$)'
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('pieChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Valor Total Investido', 'Total de Juros'], // Labels atualizados
                    datasets: [{
                        data: [totalInvested, totalInterest], // Dados atualizados
                        backgroundColor: ['#7DB667', '#FF6384'], // Cores correspondentes
                        hoverBackgroundColor: ['#7DB667', '#FF6384'] // Cores de hover correspondentes
                    }]
                },
                options: {
                    responsive: true
                }
            });
            // Verificação para exibir o modal de banner
              // Exibir o banner se o valor total final for igual ou superior a 350.000
            if (totalAmount >= 350000) {
                document.getElementById('banner').style.display = 'block';
            }
        }

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        /*function clearGraphsAndTable() {
            // Limpa os gráficos
            var ctx = document.getElementById('investmentChart');
            var chartInstance = new Chart(ctx, {});
            ctx = document.getElementById('pieChart');
            chartInstance = new Chart(ctx, {});

            // Limpa a tabela
            document.querySelector('#breakdownTable tbody').innerHTML = '';
        }*/

        // Set the default tab to be open
        document.getElementById("defaultTab").click();

        function formatCurrency(value) {
            return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }
    </script>
</body>
</html>

?>

