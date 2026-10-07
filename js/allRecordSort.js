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

    // Attach toggle function to selectAll checkbox
    document.getElementById('selectAll').addEventListener('click', function(event) {
        toggle(event.target);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', searchTable);
});

function toggle(source) {
    let checkboxes = document.querySelectorAll('tbody tr:not(.hide) .select');
    checkboxes.forEach(checkbox => checkbox.checked = source.checked);
}

function searchTable() {

    let searchValue = document.getElementById('searchInput').value.toLowerCase();
    let tableRows = document.querySelectorAll('tbody tr');
    let visibleRows = [];

    tableRows.forEach(row => {
        let containsCheckbox = row.querySelector('input[type="checkbox"]');
        if ((!containsCheckbox || !containsCheckbox.checked) && row.textContent.toLowerCase().includes(searchValue)) {
            row.style.display = '';
            visibleRows.push(row);
        } else {
            row.style.display = 'none';
        }
    });

    visibleRows.forEach((row, i) => {
        row.style.setProperty('--delay', (i * 0.1) + 's');
        row.classList.remove('hide');
    });

    document.querySelectorAll('tbody tr').forEach(row => {
        if (!visibleRows.includes(row)) {
            row.classList.add('hide');
        }
    });

    let rowCountPage = visibleRows.length;
    document.querySelector('.result-count').textContent = rowCountPage;
}

// Sorting table
function sortTable(column, sort_asc) {
    let table_rows = Array.from(document.querySelectorAll('tbody tr'));
    let sorted_rows = table_rows.sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase();
        let second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    });

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
        head.classList.toggle('asc', sort_asc);
        sortTable(i, sort_asc);
    }
});







































// // 6. Converting HTML table to EXCEL File

// const excel_btn = document.querySelector('#toEXCEL');

// const toExcel = function (table) {
//     // Code For SIMPLE TABLE
//     // const t_rows = table.querySelectorAll('tr');
//     // return [...t_rows].map(row => {
//     //     const cells = row.querySelectorAll('th, td');
//     //     return [...cells].map(cell => cell.textContent.trim()).join('\t');
//     // }).join('\n');

//     const t_heads = table.querySelectorAll('th'),
//         tbody_rows = table.querySelectorAll('tbody tr');

//     const headings = [...t_heads].map(head => {
//         let actual_head = head.textContent.trim().split(' ');
//         return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
//     }).join('\t') + '\t' + 'image name';

//     const table_data = [...tbody_rows].map(row => {
//         const cells = row.querySelectorAll('td'),
//             img = decodeURIComponent(row.querySelector('img').src),
//             data_without_img = [...cells].map(cell => cell.textContent.trim()).join('\t');

//         return data_without_img + '\t' + img;
//     }).join('\n');

//     return headings + '\n' + table_data;
// }

// excel_btn.onclick = () => {
//     const excel = toExcel(customers_table);
//     downloadFile(excel, 'excel');
// }

// const downloadFile = function (data, fileType, fileName = '') {
//     const a = document.createElement('a');
//     a.download = fileName;
//     const mime_types = {
//         'json': 'application/json',
//         'csv': 'text/csv',
//         'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//     }
//     a.href = `
//         data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
//     `;
//     document.body.appendChild(a);
//     a.click();
//     a.remove();
// }
