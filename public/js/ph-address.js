/**
 * Philippine Address Selectors using PSGC API (Custom Dropdown Variant)
 * Replaces native datalist with a custom styled dropdown below the input.
 */

document.addEventListener('DOMContentLoaded', function () {
    setupDropdown('ph-region-input', 'ph-region-list');
    setupDropdown('ph-province-input', 'ph-province-list');
    setupDropdown('ph-city-input', 'ph-city-list');
    setupDropdown('ph-barangay-input', 'ph-barangay-list');

    const regionInput = document.getElementById('ph-region-input');
    const provinceInput = document.getElementById('ph-province-input');
    const cityInput = document.getElementById('ph-city-input');
    const barangayInput = document.getElementById('ph-barangay-input');

    const regionList = document.getElementById('ph-region-list');
    const provinceList = document.getElementById('ph-province-list');
    const cityList = document.getElementById('ph-city-list');
    const barangayList = document.getElementById('ph-barangay-list');

    if (!regionInput || !regionList) return;

    const sortByName = (a, b) => a.name.localeCompare(b.name);

    // Global click listener to close dropdowns
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.ph-dd-wrap')) {
            document.querySelectorAll('.ph-dd-list').forEach(list => list.style.display = 'none');
        }
    });

    function setupDropdown(inputId, listId) {
        const input = document.getElementById(inputId);
        const list = document.getElementById(listId);
        if (!input || !list) return;

        // Show dropdown on focus
        input.addEventListener('focus', () => {
            // hide all others
            document.querySelectorAll('.ph-dd-list').forEach(l => l.style.display = 'none');
            if (list.children.length > 0) list.style.display = 'block';
        });

        // Filter list on input
        input.addEventListener('input', () => {
            const filter = input.value.toLowerCase();
            let hasVisible = false;
            Array.from(list.children).forEach(li => {
                if (li.textContent.toLowerCase().includes(filter)) {
                    li.style.display = 'block';
                    hasVisible = true;
                } else {
                    li.style.display = 'none';
                }
            });
            list.style.display = hasVisible ? 'block' : 'none';
        });

        // Handle item click (event delegation)
        list.addEventListener('mousedown', (e) => {
            if (e.target.tagName === 'LI') {
                input.value = e.target.textContent;
                input.dataset.code = e.target.dataset.code;
                list.style.display = 'none';
                // Trigger change event programmatically for dependents
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    function populateList(listEl, inputEl, data) {
        listEl.innerHTML = '';
        inputEl.dataset.code = ''; // reset code
        data.forEach(item => {
            let li = document.createElement('li');
            li.textContent = item.name;
            li.dataset.code = item.code;
            listEl.appendChild(li);
        });
    }

    // Load Regions
    fetch('https://psgc.gitlab.io/api/regions/')
        .then(res => res.json())
        .then(data => {
            data.sort(sortByName);
            populateList(regionList, regionInput, data);
        }).catch(err => console.error(err));

    // When Region changes
    regionInput.addEventListener('change', function () {
        provinceInput.value = ''; cityInput.value = ''; barangayInput.value = '';
        provinceList.innerHTML = ''; cityList.innerHTML = ''; barangayList.innerHTML = '';
        provinceInput.disabled = true; cityInput.disabled = true; barangayInput.disabled = true;

        const code = this.dataset.code;
        if (!code) {
            provinceInput.disabled = false; cityInput.disabled = false; barangayInput.disabled = false;
            return;
        }

        fetch(`https://psgc.gitlab.io/api/regions/${code}/provinces/`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    data.sort(sortByName);
                    populateList(provinceList, provinceInput, data);
                    provinceInput.disabled = false;
                } else {
                    // NCR edge case
                    provinceInput.value = this.value;
                    provinceInput.dataset.code = code;
                    fetchCities(`https://psgc.gitlab.io/api/regions/${code}/cities-municipalities/`);
                }
            });
    });

    // When Province changes
    provinceInput.addEventListener('change', function () {
        cityInput.value = ''; barangayInput.value = '';
        cityList.innerHTML = ''; barangayList.innerHTML = '';
        cityInput.disabled = true; barangayInput.disabled = true;

        const code = this.dataset.code;
        if (!code) { cityInput.disabled = false; barangayInput.disabled = false; return; }
        fetchCities(`https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`);
    });

    function fetchCities(url) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                data.sort(sortByName);
                populateList(cityList, cityInput, data);
                cityInput.disabled = false;
            });
    }

    // When City changes
    cityInput.addEventListener('change', function () {
        barangayInput.value = '';
        barangayList.innerHTML = '';
        barangayInput.disabled = true;

        const code = this.dataset.code;
        if (!code) { barangayInput.disabled = false; return; }
        fetch(`https://psgc.gitlab.io/api/cities-municipalities/${code}/barangays/`)
            .then(res => res.json())
            .then(data => {
                data.sort(sortByName);
                populateList(barangayList, barangayInput, data);
                barangayInput.disabled = false;
            });
    });
});
