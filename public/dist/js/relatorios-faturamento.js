$(document).ready(function() {
    // Inicializar gráficos do relatório de faturamento
    initFaturamentoCharts();
    
    // Configurar filtros de data
    setupDateFilters();
});

function initFaturamentoCharts() {
    // Configurações globais
    Chart.defaults.font.family = 'Arial, sans-serif';
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#5a5c69';
    
    const colors = {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        secondary: '#858796'
    };
    
    // Inicializar gráfico de faturamento por categoria
    if (typeof faturamentoCategoria !== 'undefined' && document.getElementById('faturamentoCategoriaChart')) {
        initFaturamentoCategoriaChart(faturamentoCategoria, colors);
    }
    
    // Inicializar gráfico de evolução diária
    if (document.getElementById('evolucaoDiariaChart')) {
        initEvolucaoDiariaChart(colors);
    }
}

function initFaturamentoCategoriaChart(data, colors) {
    const ctx = document.getElementById('faturamentoCategoriaChart').getContext('2d');
    
    // Preparar dados
    const labels = data.map(item => item.categoria);
    const valores = data.map(item => parseFloat(item.faturamento));
    
    // Calcular total para percentuais
    const total = valores.reduce((sum, value) => sum + value, 0);
    
    const backgroundColors = [
        colors.primary,
        colors.success,
        colors.info,
        colors.warning,
        colors.danger,
        colors.secondary
    ];
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: valores,
                backgroundColor: backgroundColors,
                borderWidth: 3,
                borderColor: '#fff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 11
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                                    return {
                                        text: label + ' (' + percentage + '%)',
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].borderColor,
                                        lineWidth: data.datasets[0].borderWidth,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                            return [
                                'Faturamento: R$ ' + value.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }),
                                'Participação: ' + percentage + '%'
                            ];
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                duration: 1000
            }
        }
    });
}

function initEvolucaoDiariaChart(colors) {
    const ctx = document.getElementById('evolucaoDiariaChart').getContext('2d');
    
    // Dados simulados - você pode substituir por dados reais via AJAX
    const labels = [];
    const dados = [];
    
    // Gerar dados dos últimos 30 dias
    for (let i = 29; i >= 0; i--) {
        const data = new Date();
        data.setDate(data.getDate() - i);
        labels.push(data.toLocaleDateString('pt-BR', { 
            day: '2-digit', 
            month: '2-digit' 
        }));
        
        // Simular faturamento diário (valores aleatórios para exemplo)
        dados.push(Math.floor(Math.random() * 1000) + 200);
    }
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Faturamento Diário',
                data: dados,
                borderColor: colors.success,
                backgroundColor: colors.success + '20',
                borderWidth: 3,
                pointBackgroundColor: colors.success,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        title: function(context) {
                            return 'Data: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Faturamento: R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
}

function setupDateFilters() {
    // Configurar máscara para campos de data
    $('.date-input').each(function() {
        $(this).attr('max', new Date().toISOString().split('T')[0]);
    });
    
    // Validar período selecionado
    $('#filtroForm').on('submit', function(e) {
        const dataInicio = new Date($('#data_inicio').val());
        const dataFim = new Date($('#data_fim').val());
        
        if (dataInicio > dataFim) {
            e.preventDefault();
            alert('A data de início não pode ser maior que a data de fim.');
            return false;
        }
        
        const diffTime = Math.abs(dataFim - dataInicio);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 365) {
            e.preventDefault();
            alert('O período selecionado não pode ser maior que 365 dias.');
            return false;
        }
    });
    
    // Botões de período rápido
    $('.btn-periodo').on('click', function(e) {
        e.preventDefault();
        const periodo = $(this).data('periodo');
        const hoje = new Date();
        let dataInicio;
        
        switch(periodo) {
            case '7d':
                dataInicio = new Date(hoje.getTime() - (7 * 24 * 60 * 60 * 1000));
                break;
            case '30d':
                dataInicio = new Date(hoje.getTime() - (30 * 24 * 60 * 60 * 1000));
                break;
            case 'mes-atual':
                dataInicio = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
                break;
            case 'mes-anterior':
                dataInicio = new Date(hoje.getFullYear(), hoje.getMonth() - 1, 1);
                const dataFim = new Date(hoje.getFullYear(), hoje.getMonth(), 0);
                $('#data_fim').val(dataFim.toISOString().split('T')[0]);
                break;
            default:
                return;
        }
        
        $('#data_inicio').val(dataInicio.toISOString().split('T')[0]);
        if (periodo !== 'mes-anterior') {
            $('#data_fim').val(hoje.toISOString().split('T')[0]);
        }
        
        $('#filtroForm').submit();
    });
}

// Função para carregar dados de movimentações por categoria via AJAX
function carregarMovimentacoesPorCategoria() {
    const dataInicio = $('#data_inicio').val();
    const dataFim = $('#data_fim').val();
    
    $.ajax({
        url: base_url + 'relatorios/ajax_dados_grafico',
        type: 'POST',
        data: {
            tipo: 'movimentacoes_categoria',
            data_inicio: dataInicio,
            data_fim: dataFim
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Atualizar tabela com dados de movimentações
                response.data.forEach(function(item) {
                    const categoriaId = item.categoria.replace(/\s+/g, '_').toLowerCase();
                    $('#mov-' + categoriaId).text(item.movimentacoes);
                    
                    if (item.movimentacoes > 0 && item.faturamento > 0) {
                        const ticketMedio = item.faturamento / item.movimentacoes;
                        $('#ticket-' + categoriaId).text('R$ ' + ticketMedio.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                    }
                });
            }
        },
        error: function() {
            console.log('Erro ao carregar dados de movimentações por categoria');
        }
    });
}

// Função para exportar dados como CSV
function exportarCSV() {
    if (typeof faturamentoCategoria === 'undefined' || !faturamentoCategoria.length) {
        alert('Não há dados para exportar.');
        return;
    }
    
    let csv = 'Categoria,Faturamento,Percentual\n';
    const total = faturamentoCategoria.reduce((sum, item) => sum + parseFloat(item.faturamento), 0);
    
    faturamentoCategoria.forEach(function(item) {
        const percentual = total > 0 ? ((parseFloat(item.faturamento) / total) * 100).toFixed(2) : '0.00';
        csv += `"${item.categoria}","${item.faturamento}","${percentual}%"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', 'faturamento-categorias.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Carregar dados adicionais quando a página estiver pronta
$(document).ready(function() {
    setTimeout(function() {
        carregarMovimentacoesPorCategoria();
    }, 1000);
});
