const btnFormHolidayCheck = document.querySelector('#formHolidayCheck button');

btnFormHolidayCheck.addEventListener('click', function () {

    const formHolidayCheck     = document.querySelector('#formHolidayCheck');
    const holidayCheckInputs   = formHolidayCheck.querySelectorAll('.form__input');
    const formHolidayCheckMessage = formHolidayCheck.querySelector('.form__message');
    const dateValue            = formHolidayCheck.querySelector('#checkDate').value;

    formHolidayCheckMessage.textContent = '';
    formHolidayCheckMessage.classList.remove('notice--error');

    // ========== TEST VALEUR FORMULAIRE

    if (!checkInputs(holidayCheckInputs, formHolidayCheckMessage)) {
        formHolidayCheckMessage.textContent = 'Paramètres incorrects : ' + formHolidayCheckMessage.textContent;
        formHolidayCheckMessage.classList.add('notice--error');
        return;
    }

    // ========== PREPARATION REQUETE

    const year = extractYear(dateValue);
    const url  = buildHolidayUrl(year, 'FR');

    // ========== EXECUTION REQUETE

    requestHolidayAPI(url)
        .then((holidays) => isPublicHoliday(dateValue, holidays))
        .then((result)   => displayHolidayResult(result, formHolidayCheckMessage))
        .catch((error)   => console.log(error));

});

/** ========== > FONCTION buildHolidayUrl()
 *
 * buildHolidayUrl() retourne l'URL de l'API nager.date
 * pour récupérer les jours fériés d'une année et d'un pays donnés
 *
 * @param {number} year    : année à interroger
 * @param {string} country : code pays ISO 3166-1 alpha-2 (ex: 'FR')
 * @returns {string}       : URL complète à exploiter avec un fetch
 *
 *  < ==========
 */

function buildHolidayUrl(year, country) {

    const urlApi = 'https://date.nager.at/api/v3/PublicHolidays/';

    return (`${urlApi}${year}/${country}`);
}

/** ========== > FONCTION requestHolidayAPI()
 *
 * requestHolidayAPI() effectue une requête GET vers l'API nager.date
 * et retourne la liste des jours fériés sous forme de tableau
 *
 * @param {string} url          : URL de l'API à interroger
 * @returns {Promise<array>}    : tableau des jours fériés retournés par l'API
 *
 *  < ==========
 */

function requestHolidayAPI(url) {

    return fetch(url)
        .then((response) => {
            if (!response.ok) throw new Error(`Erreur API : ${response.status}`);
            return response.json();
        });
}

/** ========== > FONCTION isPublicHoliday()
 *
 * isPublicHoliday() vérifie si la date fournie correspond à un jour férié
 * parmi la liste retournée par l'API nager.date
 *
 * @param {string} date      : date à vérifier au format YYYY-MM-DD
 * @param {array}  holidays  : tableau des jours fériés retournés par l'API
 * @returns {object|null}    : l'objet jour férié trouvé, ou null si aucun
 *
 *  < ==========
 */

function isPublicHoliday(date, holidays) {

    const match = holidays.find((holiday) => holiday.date === date);

    return match ?? null;
}

/** ========== > FONCTION displayHolidayResult()
 *
 * displayHolidayResult() affiche dans l'élément fourni le résultat
 * de la vérification de jour férié
 *
 * @param {object|null} result : résultat retourné par isPublicHoliday()
 * @param {HTMLElement} msgEl  : élément du DOM destiné à afficher le message
 * @returns {*}                : /
 *
 *  < ==========
 */

function displayHolidayResult(result, msgEl) {

    if (result) {
        msgEl.textContent = `Cette date est un jour férié : ${result.localName}.`;
        msgEl.classList.add('notice--error');
        console.log("test");
    } else {
        msgEl.textContent = `Cette date n'est pas un jour férié.`;
        msgEl.classList.add('notice--success');
    }
}

/** ========== > FONCTION checkInputs()
 *
 * checkInputs() vérifie si les champs requis du formulaire sont bien remplis
 * et affiche un message d'erreur dans l'élément fourni si ce n'est pas le cas
 *
 * @param {NodeList}    inputs : liste des inputs à vérifier
 * @param {HTMLElement} msgEl  : élément du DOM destiné à afficher les erreurs
 * @returns {boolean}          : true si tous les champs requis sont remplis, false sinon
 *
 *  < ==========
 */

function checkInputs(inputs, msgEl) {

    let check = true;

    if (inputs && inputs.length > 0) {

        inputs.forEach((input) => {
            if (input.value === '' && input.required === true) {
                msgEl.textContent += `${input.placeholder || input.name} est obligatoire ! `;
                check = false;
            }
        });

    } else {
        check = false;
    }

    return check;
}

/** ========== > FONCTION extractYear()
 *
 * extractYear() extrait et retourne l'année depuis une date au format YYYY-MM-DD
 *
 * @param {string} date  : date au format YYYY-MM-DD
 * @returns {number}     : année extraite
 *
 *  < ==========
 */

function extractYear(date) {

    return Number(date.split('-')[0]);
}