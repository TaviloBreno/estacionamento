/**
 * JavaScript para página de sucesso do estacionamento
 * Controla a impressão automática e outras funcionalidades
 */

$(document).ready(function() {
    // Configurações
    var autoprint_delay = 3000; // 3 segundos
    var countdown_element = '#countdown-timer';
    var autoprint_enabled = true;
    
    // Elemento para countdown
    var countdown_html = `
        <div id="autoprint-dialog" class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <h6><i class="fa fa-print mr-2"></i>Impressão Automática</h6>
            <p class="mb-2">O ticket será impresso automaticamente em <span id="countdown-timer">3</span> segundos.</p>
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm" id="print-now">
                    <i class="fa fa-print mr-1"></i>Imprimir Agora
                </button>
                <button type="button" class="btn btn-secondary btn-sm" id="cancel-autoprint">
                    <i class="fa fa-times mr-1"></i>Cancelar
                </button>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Adicionar dialog de impressão automática
    $('.card-body').prepend(countdown_html);
    
    var countdown = 3;
    var countdown_interval;
    var print_url = $('#print-ticket-btn').attr('href');
    
    // Função para imprimir ticket
    function printTicket() {
        if (print_url) {
            window.open(print_url, '_blank');
            $('#autoprint-dialog').fadeOut();
            
            // Mostrar mensagem de sucesso
            showNotification('Ticket enviado para impressão!', 'success');
        }
    }
    
    // Função para mostrar notificação
    function showNotification(message, type) {
        var notification = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;
        $('.card-body').prepend(notification);
        
        // Remover após 5 segundos
        setTimeout(function() {
            $('.alert').last().fadeOut();
        }, 5000);
    }
    
    // Iniciar countdown
    function startCountdown() {
        countdown_interval = setInterval(function() {
            countdown--;
            $('#countdown-timer').text(countdown);
            
            if (countdown <= 0) {
                clearInterval(countdown_interval);
                if (autoprint_enabled) {
                    printTicket();
                }
            }
        }, 1000);
    }
    
    // Event listeners
    $('#print-now').click(function() {
        clearInterval(countdown_interval);
        printTicket();
    });
    
    $('#cancel-autoprint').click(function() {
        clearInterval(countdown_interval);
        autoprint_enabled = false;
        $('#autoprint-dialog').fadeOut();
        showNotification('Impressão automática cancelada. Você pode imprimir manualmente usando o botão "Imprimir Ticket".', 'info');
    });
    
    // Fechar dialog ao clicar no X
    $('#autoprint-dialog .close').click(function() {
        clearInterval(countdown_interval);
        autoprint_enabled = false;
    });
    
    // Iniciar countdown após carregar a página
    setTimeout(startCountdown, 500);
    
    // Adicionar efeitos visuais
    $('.card').addClass('animate__animated animate__fadeInUp');
    
    // Funcionalidade de cópia do código do ticket
    $('.ticket-code').click(function() {
        var ticket_code = $(this).find('.badge').text();
        
        // Tentar copiar para clipboard
        if (navigator.clipboard) {
            navigator.clipboard.writeText(ticket_code).then(function() {
                showNotification('Código do ticket copiado: ' + ticket_code, 'success');
            });
        } else {
            // Fallback para navegadores mais antigos
            var textArea = document.createElement("textarea");
            textArea.value = ticket_code;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                showNotification('Código do ticket copiado: ' + ticket_code, 'success');
            } catch (err) {
                showNotification('Erro ao copiar código', 'warning');
            }
            document.body.removeChild(textArea);
        }
    });
    
    // Adicionar tooltip para indicar que é clicável
    $('.ticket-code .badge').attr('title', 'Clique para copiar o código').addClass('cursor-pointer');
    
    // Atualizar horário em tempo real
    function updateCurrentTime() {
        var now = new Date();
        var timeString = now.toLocaleString('pt-BR', {
            day: '2-digit',
            month: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        if ($('#current-time').length === 0) {
            $('.footer').prepend('<p id="current-time"><small class="text-muted">Horário atual: ' + timeString + '</small></p>');
        } else {
            $('#current-time').html('<small class="text-muted">Horário atual: ' + timeString + '</small>');
        }
    }
    
    // Atualizar a cada segundo
    setInterval(updateCurrentTime, 1000);
    updateCurrentTime();
});

// CSS adicional para melhor experiência
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .cursor-pointer { cursor: pointer; }
        .animate__animated { animation-duration: 0.8s; }
        .animate__fadeInUp {
            animation-name: fadeInUp;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        #autoprint-dialog {
            border-left: 4px solid #17a2b8;
        }
        .ticket-code .badge:hover {
            background-color: #0056b3 !important;
            transform: scale(1.05);
            transition: all 0.2s ease;
        }
    `)
    .appendTo('head');
