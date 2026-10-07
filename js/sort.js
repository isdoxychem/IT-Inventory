document.addEventListener('DOMContentLoaded', function() {
    // Apply classes to status spans
    var spans = document.getElementsByClassName("statusSpan");
    for (var i = 0; i < spans.length; i++) {
        var span = spans[i];
        if (span.innerHTML === 'Deployed') { span.classList.add("status", "deployed"); } 
        else if (span.innerHTML === 'To be deploy') { span.classList.add("status", "tobedeploy"); } 
        else if (span.innerHTML === 'Outdated') { span.classList.add("status", "outdated"); } 
        else if (span.innerHTML === 'For repair') { span.classList.add("status", "repair"); } 
        else if (span.innerHTML === 'Sell' || span.innerHTML === 'Defective') { span.classList.add("status", "replace"); } 
        else if (span.innerHTML === '1') { span.innerText = 'Active'; span.classList.add("status", "tobedeploy"); }
        else if (span.innerHTML === '0') { span.innerText = 'Inactive'; span.classList.add("status", "missing"); }
        else { span.classList.add("status", "missing"); }
    }

    var docuSpans = document.getElementsByClassName("documentStatus");
    for (var i = 0; i < docuSpans.length; i++) {
        var docuSpan = docuSpans[i];
        if (docuSpan.innerHTML === '3') { docuSpan.innerText = 'Turned over'; docuSpan.classList.add("docu", "turnedover"); } 
        else if (docuSpan.innerHTML === '2') { docuSpan.innerText = 'Signed'; docuSpan.classList.add("docu", "signed"); } 
        else if (docuSpan.innerHTML === '1') { docuSpan.innerText = 'On Process'; docuSpan.classList.add("docu", "processing"); }
        else { docuSpan.innerText = '0'; docuSpan.innerText = 'N/A'; docuSpan.classList.add("docu", "missing"); }
    }

    // Attach toggle function to selectAll checkbox
    document.getElementById('selectAll').addEventListener('click', function(event) {
        toggle(event.target);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', searchTable);
});


function searchTable() {
    let searchValue = document.getElementById('searchInput').value.toLowerCase();
    let visibleRows = Array.from(document.querySelectorAll('tbody tr')).filter(row => {
    let containsCheckbox = row.querySelector('input[type="checkbox"]');
        return row.textContent.toLowerCase().includes(searchValue);
    });

    visibleRows.forEach((row, i) => {
        row.style.setProperty('--delay', (i * 0.1) + 's');
        row.classList.remove('hide');
    });

    document.querySelectorAll('tbody tr').forEach(row => {
        if (!visibleRows.includes(row)) {
            row.classList.add('hide');
            // row.classList.remove('hide');
        }
    });

    let rowCountPage = visibleRows.length;
    document.querySelector('.result-count').textContent = rowCountPage;
}

function searchAccTable() {
    let searchValue = document.getElementById('searchAccInput').value.toLowerCase();
    let visibleRows = Array.from(document.querySelectorAll('tbody tr.acc')).filter(row => {
        let containsCheckbox = row.querySelector('input[type="checkbox"]');
        return row.textContent.toLowerCase().includes(searchValue);
    });

    visibleRows.forEach((row, i) => {
        row.style.setProperty('--delay', (i * 0.1) + 's');
        row.classList.remove('hide');
    });

    document.querySelectorAll('tbody tr.acc').forEach(row => {
        if (!visibleRows.includes(row)) {
            row.classList.add('hide');
        }
    });

    let accCountPage = visibleRows.length;
    document.querySelector('.acc-result-count').textContent = accCountPage;
}

function searchTrnTable() {
    let searchValue = document.getElementById('searchTrnInput').value.toLowerCase();
    let visibleRows = Array.from(document.querySelectorAll('tbody tr.trn')).filter(row => {
        let containsCheckbox = row.querySelector('input[type="checkbox"]');
        return (!containsCheckbox || !containsCheckbox.checked) && row.textContent.toLowerCase().includes(searchValue);
    });

    visibleRows.forEach((row, i) => {
        row.style.setProperty('--delay', (i * 0.1) + 's');
        row.classList.remove('hide');
    });

    document.querySelectorAll('tbody tr.trn').forEach(row => {
        if (!visibleRows.includes(row)) {
            row.classList.add('hide');
        }
    });

    let trnCountPage = visibleRows.length;
    document.querySelector('.trn-result-count').textContent = trnCountPage;
}

function sortRows(a, b) {
    const aMatches = a.querySelector('td[data-column="assettag"]').textContent.match(/\d+$/);
    const bMatches = b.querySelector('td[data-column="assettag"]').textContent.match(/\d+$/);
    const aNum = aMatches ? parseInt(aMatches[0], 10) : 0;
    const bNum = bMatches ? parseInt(bMatches[0], 10) : 0;

    if (aNum === bNum) {
        return a.querySelector('td[data-column="assettag"]').textContent.localeCompare(b.querySelector('td[data-column="assettag"]').textContent);
    }
    return aNum - bNum;
}

function sortTable(column, sort_asc) {
    let table_rows = Array.from(document.querySelectorAll('tbody tr'));
    let sorted_rows;

    if (column === 'assettag') {
        sorted_rows = table_rows.sort((a, b) => sort_asc ? sortRows(a, b) : sortRows(b, a));
    } else {
        sorted_rows = table_rows.sort((a, b) => {
            let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase();
            let second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();
            return sort_asc ? (first_row < second_row ? -1 : 1) : (first_row < second_row ? 1 : -1);
        });
    }

    let tbody = document.querySelector('tbody');
    sorted_rows.forEach(row => {
        tbody.appendChild(row);
    });
}

document.querySelectorAll('thead th').forEach((head, i) => {
    let sort_asc = true;
    head.onclick = () => {
        document.querySelectorAll('thead th').forEach(th => th.classList.remove('active'));
        head.classList.add('active');
        sort_asc = !sort_asc;
        head.classList.toggle('ASC', sort_asc);
        sortTable(i, sort_asc);
    }
});
// function sortRows(a, b) {
//     const aMatches = a.querySelector('td[data-column="assettag"]').textContent.match(/\d+$/);
//     const bMatches = b.querySelector('td[data-column="assettag"]').textContent.match(/\d+$/);
//     const aNum = aMatches ? parseInt(aMatches[0], 10) : 0;
//     const bNum = bMatches ? parseInt(bMatches[0], 10) : 0;

//     if (aNum === bNum) {
//         return a.querySelector('td[data-column="assettag"]').textContent.localeCompare(b.querySelector('td[data-column="assettag"]').textContent);
//     }
//     return aNum - bNum;
// }

// function sortTable(column, sort_asc) {
//     let table_rows = Array.from(document.querySelectorAll('tbody tr'));
//     let sorted_rows;

//     if (column === 'assettag') {
//         // If sorting by AssetTag, sort numerically
//         sorted_rows = table_rows.sort((a, b) => sort_asc ? sortRows(a, b) : sortRows(b, a));
//     } else {
//         // Sort other columns alphabetically
//         sorted_rows = table_rows.sort((a, b) => {
//             let first_row = a.querySelector(`td[data-column="${column}"]`).textContent.trim().toLowerCase();
//             let second_row = b.querySelector(`td[data-column="${column}"]`).textContent.trim().toLowerCase();
            
//             return sort_asc ? first_row.localeCompare(second_row) : second_row.localeCompare(first_row);
//         });
//     }

//     let tbody = document.querySelector('tbody');
//     sorted_rows.forEach(row => tbody.appendChild(row));
// }

// // Event listener for sorting
// document.querySelectorAll('thead th').forEach((head) => {
//     let sort_asc = true;
//     head.onclick = () => {
//         document.querySelectorAll('thead th').forEach(th => th.classList.remove('active'));
//         head.classList.add('active');
        
//         sort_asc = !sort_asc;
//         head.classList.toggle('asc', sort_asc);
        
//         let column = head.getAttribute('data-column'); // Use data-column instead of index
//         sortTable(column, sort_asc);
//     };
// });
