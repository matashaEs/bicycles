const addButtonList = document.querySelectorAll('.btn_add');

addButtonList.forEach(addButton => {
    addButton.addEventListener('click', () => {
        const nextElement = addButton.parentElement.parentElement.nextSibling.nextElementSibling;
        if (nextElement) {
            nextElement.classList.remove('hidden');
        }
    });
});