import axios from 'axios';

function generateUniqueValue() {
    const timestamp = new Date().getTime();
    const random = Math.floor(Math.random() * 1000);
    return timestamp + '_' + random;
}

export function makeSelectInputGroup(urlAPI, target, entity, labelQuantity, precision) {
    // Créer l'élément div avec les classes "row" et "mb-3"
    const rowDiv = document.createElement('div');
    rowDiv.className = 'row mb-3 apparition';

    // Créer le premier div avec les classes "col-md-6" et "col-12"
    const col1Div = document.createElement('div');
    col1Div.className = 'col-md-7 col-12';

    // Créer le select avec les classes "form-select" et "custom-select"
    const selectElement = document.createElement('select');
    selectElement.className = 'form-select custom-select';
    selectElement.setAttribute('aria-label', 'Select a ' + entity);
    selectElement.setAttribute('id', 'sample_preparation_' + entity + '_' + generateUniqueValue());
    selectElement.setAttribute('data-input--card-target', 'input');
    selectElement.setAttribute('data-input--calculator--preparation-target', entity);
    selectElement.setAttribute('data-input--calculator--preparation-target', entity);
    selectElement.setAttribute('data-action', 'change->input--calculator--preparation#update');

    axios.get(urlAPI).then((response) => {
        response.data.forEach((opt) => {
            const defaultOption = document.createElement('option');
            defaultOption.setAttribute('value', opt.code);
            defaultOption.textContent = opt.name;
            selectElement.appendChild(defaultOption);
        });
    });

    // Ajouter le select dans le premier div
    col1Div.appendChild(selectElement);

    // Créer le deuxième div avec les classes "col-md-4" et "col-12"
    const col2Div = document.createElement('div');
    col2Div.className = 'col-md-4 col-12';

    // Créer l'input avec les classes "form-control" et "type-number"
    const inputElement = document.createElement('input');
    inputElement.className = 'form-control';
    inputElement.setAttribute('type', 'number');
    inputElement.setAttribute('step', precision);
    inputElement.setAttribute('min', '0');
    inputElement.setAttribute('aria-label', labelQuantity);
    inputElement.setAttribute('placeholder', labelQuantity);
    inputElement.setAttribute('data-input--card-target', 'input');
    inputElement.setAttribute('data-input--calculator--preparation-target', entity + 'Value');
    inputElement.setAttribute('data-action', 'change->input--calculator--preparation#update');

    // Ajouter l'input dans le deuxième div
    col2Div.appendChild(inputElement);

    // Créer le troisième div avec la classe "col-2" pour la croix rouge
    const col3Div = document.createElement('div');
    col3Div.className = 'col-1 text-center';

    // Créer la croix rouge en tant qu'élément <i> avec les classes "bi" et "bi-x-circle"
    const crossIcon = document.createElement('i');
    crossIcon.className = 'fa-solid fa-xmark text-danger fs-2 mHPointer';
    crossIcon.setAttribute('data-action', 'click->input--calculator--preparation#removeSelection');

    // Ajouter la croix rouge dans le troisième div
    col3Div.appendChild(crossIcon);

    // Ajouter les trois divs dans le div avec l'id "dynamicContent"
    rowDiv.appendChild(col1Div);
    rowDiv.appendChild(col2Div);
    rowDiv.appendChild(col3Div);

    target.appendChild(rowDiv);
}

export function formatFloat(number) {
    // Convertir le nombre en chaîne de caractères
    const numberString = number.toString();

    // Trouver l'index de la première décimale après la virgule
    const decimalIndex = numberString.indexOf('.');

    // Si le nombre est au format scientifique (ex: 1e-7)
    if (numberString.includes('e')) {
        const [value, exponent] = numberString.split('e');
        return formatFloat(parseFloat(value)) + 'e' + exponent;
    }

    // Si le nombre n'a pas de décimale, le retourner tel quel
    if (decimalIndex === -1) {
        return numberString;
    }

    // Vérifier s'il y a plus de 5 décimales
    const decimals = numberString.substring(decimalIndex + 1);
    if (decimals.length > 5) {
        // Rechercher l'index de la première décimale différente de 0 à partir de la 5e décimale
        let firstNonZeroIndex = decimalIndex + 6;
        while (firstNonZeroIndex < numberString.length && numberString.charAt(firstNonZeroIndex) === '0') {
            firstNonZeroIndex++;
        }

        // Retourner le nombre jusqu'à la première décimale différente de 0
        return numberString.substring(0, firstNonZeroIndex);
    }

    // Retourner le nombre tel quel s'il a 5 décimales ou moins
    return numberString;
}
