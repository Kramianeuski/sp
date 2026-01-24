        </main>
    </div>
</div>
<script>
    document.querySelectorAll('[data-tabs]').forEach((tabs) => {
        const buttons = tabs.querySelectorAll('[data-tab-target]');
        const panels = document.querySelectorAll(`[data-tab-panel][data-tab-group=\"${tabs.dataset.tabs}\"]`);
        const activate = (target) => {
            buttons.forEach((button) => {
                button.classList.toggle('is-active', button.dataset.tabTarget === target);
            });
            panels.forEach((panel) => {
                panel.classList.toggle('is-active', panel.dataset.tabPanel === target);
            });
        };
        buttons.forEach((button) => {
            button.addEventListener('click', () => activate(button.dataset.tabTarget));
        });
        if (buttons[0]) {
            activate(buttons[0].dataset.tabTarget);
        }
    });
</script>
</body>
</html>
