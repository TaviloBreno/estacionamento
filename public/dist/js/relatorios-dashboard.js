$(document).ready(function() {
    // Inicializar todos os gráficos do dashboard
    initDashboardCharts();
    
    // Atualizar dados a cada 5 minutos
    setInterval(function() {
        updateDashboardData();
    }, 300000);
});

function initDashboardCharts() {
    // Configurações globais do Chart.js
    Chart.defaults.font.family = 'Arial, sans-serif';
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#5a5c69';
    
    // Cores padrão para os gráficos
    const colors = {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        secondary: '#858796'
    };
    
    // Inicializar gráfico de fluxo diário se existir
    if (typeof fluxoDiario !== 'undefined' && document.getElementById('fluxoDiarioChart')) {
        initFluxoDiarioChart(fluxoDiario, colors);
    }
    
    // Inicializar gráfico de ocupação por categoria se existir
    if (typeof ocupacaoCategoria !== 'undefined' && document.getElementById('ocupacaoCategoriaChart')) {
        initOcupacaoCategoriaChart(ocupacaoCategoria, colors);
    }
    
    // Inicializar gráfico de faturamento mensal se existir
    if (typeof faturamentoMensal !== 'undefined' && document.getElementById('faturamentoMensalChart')) {
        initFaturamentoMensalChart(faturamentoMensal, colors);
    }
    
    // Inicializar gráfico de clientes por dia se existir
    if (typeof clientesPorDia !== 'undefined' && document.getElementById('clientesPorDiaChart')) {
        initClientesPorDiaChart(clientesPorDia, colors);
    }
}

function initFluxoDiarioChart(data, colors) {
    const ctx = document.getElementById('fluxoDiarioChart').getContext('2d');
    
    // Preparar dados
    const labels = data.map(item => {
        const date = new Date(item.data);
        return date.toLocaleDateString('pt-BR', { 
            day: '2-digit', 
            month: '2-digit' 
        });
    });
    
    const entradas = data.map(item => parseInt(item.entradas));
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Entradas',
                data: entradas,
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
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
                    borderColor: colors.primary,
                    borderWidth: 1,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    callbacks: {
                        title: function(context) {
                            return 'Data: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Entradas: ' + context.parsed.y + ' veículos';
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
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                }
            }
        }
    });
}

function initOcupacaoCategoriaChart(data, colors) {
    const ctx = document.getElementById('ocupacaoCategoriaChart').getContext('2d');
    
    // Preparar dados
    const labels = data.map(item => item.categoria);
    const valores = data.map(item => parseInt(item.ocupadas));
    
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
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' vagas (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
}

function initFaturamentoMensalChart(data, colors) {
    const ctx = document.getElementById('faturamentoMensalChart').getContext('2d');
    
    // Preparar dados
    const labels = data.map(item => {
        const date = new Date(item.mes + '-01');
        return date.toLocaleDateString('pt-BR', {
            month: 'short',
            year: 'numeric'
        }).replace('.', '');
    });
    
    const valores = data.map(item => parseFloat(item.faturamento));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Faturamento',
                data: valores,
                backgroundColor: colors.success + '80',
                borderColor: colors.success,
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false,
                hoverBackgroundColor: colors.success,
                hoverBorderColor: colors.success
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                            return 'Mês: ' + context[0].label;
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
            }
        }
    });
}

function initClientesPorDiaChart(data, colors) {
    const ctx = document.getElementById('clientesPorDiaChart').getContext('2d');
    
    // Preparar dados
    const labels = data.map(item => {
        const date = new Date(item.data);
        return date.toLocaleDateString('pt-BR', { 
            day: '2-digit', 
            month: '2-digit' 
        });
    });
    
    const clientes = data.map(item => parseInt(item.clientes_unicos));
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Clientes Únicos',
                data: clientes,
                borderColor: colors.danger,
                backgroundColor: colors.danger + '20',
                borderWidth: 3,
                pointBackgroundColor: colors.danger,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
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
                            return 'Clientes: ' + context.parsed.y;
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
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                }
            }
        }
    });
}

function updateDashboardData() {
    // Função para atualizar dados do dashboard via AJAX
    $.ajax({
        url: base_url + 'relatorios/ajax_dados_grafico',
        type: 'POST',
        data: { tipo: 'dashboard_update' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Atualizar estatísticas se necessário
                console.log('Dashboard atualizado com sucesso');
            }
        },
        error: function() {
            console.log('Erro ao atualizar dashboard');
        }
    });
}

// Função auxiliar para animar números
function animateNumber(element, start, end, duration) {
    const range = end - start;
    const increment = end > start ? 1 : -1;
    const stepTime = Math.abs(Math.floor(duration / range));
    let current = start;
    
    const timer = setInterval(function() {
        current += increment;
        element.text(current);
        
        if (current === end) {
            clearInterval(timer);
        }
    }, stepTime);
}

// Função para exportar gráfico como imagem
function exportChartAsImage(chartId, filename) {
    const canvas = document.getElementById(chartId);
    const url = canvas.toDataURL('image/png');
    
    const link = document.createElement('a');
    link.download = filename + '.png';
    link.href = url;
    link.click();
}
