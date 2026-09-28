</div>

</div>
<script>

function showSuccess() {

    const check = document.createElement("div");

    check.className = "success-check";

    check.innerHTML = "✓";

    document.body.appendChild(check);

    setTimeout(function() {

        check.classList.add("show");

    }, 10);

    setTimeout(function() {

        check.remove();

    }, 1300);

}

</script>
</body>

</html>