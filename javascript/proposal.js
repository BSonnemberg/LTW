function toggleProposalInput(button) {
    const productId = button.getAttribute('data-product-id');
    const proposalInputContainer = document.getElementById(`proposal-input-container-${productId}`);
    if (proposalInputContainer.style.display === 'none' || proposalInputContainer.style.display === '') {
        proposalInputContainer.style.display = 'block';
    } else {
        proposalInputContainer.style.display = 'none';
    }
}

function submitProposal(button) {

    const productId = button.getAttribute('data-product-id');
    const proposalInput = document.getElementById(`proposal-input-${productId}`);
    const amount = proposalInput.value;

    console.log(`Submitting proposal for productId: ${productId}, amount: ${amount}`); 

    const request = new XMLHttpRequest();
    request.open("POST", "../actions/action_addProposal.php", true);
    request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    const data = `product_id=${productId}&amount=${amount}`;

    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            console.log("Proposal submitted successfully:", request.responseText);
            location.reload();
        } else {
            console.error("Error submitting proposal:", request.statusText);
        }
    };

    request.onerror = function() {
        console.error("Error during AJAX request.");
    };

    request.send(data);
}

function toggleProposalList() {
    const proposalList = document.getElementById('proposal-list');
    if (proposalList.style.display === 'none' || proposalList.style.display === '') {
        proposalList.style.display = 'block';
    } else {
        proposalList.style.display = 'none';
    }
}

function acceptProposal(proposalId, price) {
    const request = new XMLHttpRequest();
    request.open("POST", "../actions/action_acceptProposal.php", true);
    request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    const data = `proposal_id=${proposalId}`;

    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            console.log("Proposal accepted successfully:", request.responseText);

            const productElement = document.getElementById('proposal-' + proposalId);
            const productElement2 = document.getElementById('price-x');

            if (productElement) {
                productElement.parentNode.removeChild(productElement);
            }
            if (productElement2) {
                productElement2.textContent = "Preço: " + price + "€";
            }

        } else {
            console.error("Error accepting proposal:", request.statusText);
        }
    };

    request.onerror = function() {
        console.error("Error during AJAX request.");
    };

    request.send(data);
}