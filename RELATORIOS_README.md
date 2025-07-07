# Sistema de Relatórios - Estacionamento

## Funcionalidades Implementadas

### 1. Dashboard Executivo
- **URL**: `/relatorios/dashboard`
- **Descrição**: Visão geral com gráficos e estatísticas principais
- **Gráficos incluídos**:
  - Fluxo de entradas dos últimos 7 dias (gráfico de linha)
  - Ocupação por categoria (gráfico de pizza)
  - Faturamento dos últimos 6 meses (gráfico de barras)
  - Clientes únicos por dia (gráfico de linha)

### 2. Relatório de Movimentações
- **URL**: `/relatorios/movimentacoes`
- **Descrição**: Relatório detalhado de todas as movimentações
- **Funcionalidades**:
  - Filtro por período (data início e fim)
  - Tabela interativa com DataTables
  - Estatísticas resumidas (total, finalizadas, em andamento, faturamento)
  - Status visual com badges coloridos

### 3. Relatório de Faturamento
- **URL**: `/relatorios/faturamento`
- **Descrição**: Análise financeira detalhada
- **Funcionalidades**:
  - Faturamento por categoria (gráfico de pizza)
  - Evolução diária do faturamento (gráfico de linha)
  - Tabela detalhada por categoria com percentuais
  - Comparativo com mês anterior

### 4. Exportação em PDF
- **URLs de exportação**:
  - `/relatorios/exportar_pdf/dashboard`
  - `/relatorios/exportar_pdf/movimentacoes`
  - `/relatorios/exportar_pdf/faturamento`
- **Funcionalidades**:
  - PDFs formatados e profissionais
  - Logos e cabeçalhos personalizados
  - Tabelas e gráficos em formato imprimível
  - Respeitam filtros de período quando aplicáveis

## Tecnologias Utilizadas

### Frontend
- **Chart.js**: Para gráficos interativos e responsivos
- **DataTables**: Para tabelas interativas com busca e paginação
- **Bootstrap 4**: Para layout responsivo e componentes
- **Font Awesome**: Para ícones
- **CSS customizado**: Estilos específicos para relatórios

### Backend
- **CodeIgniter 3**: Framework PHP
- **MySQL**: Banco de dados para consultas
- **DomPDF**: Geração de PDFs
- **Model específico**: `Relatorios_model` para consultas otimizadas

## Como Usar

### 1. Acessar Relatórios
```
1. Faça login no sistema
2. No dashboard principal, clique em "Relatórios"
3. Escolha o tipo de relatório desejado
```

### 2. Filtrar por Período
```
1. Acesse qualquer relatório com filtros
2. Selecione a data de início
3. Selecione a data de fim
4. Clique em "Filtrar"
```

### 3. Exportar PDF
```
1. Acesse o relatório desejado
2. Configure os filtros se necessário
3. Clique em "Exportar PDF"
4. O arquivo será baixado automaticamente
```

## Estrutura de Arquivos Criados

```
application/
├── controllers/
│   └── Relatorios.php (Controller principal)
├── models/
│   └── Relatorios_model.php (Model com consultas)
├── views/
│   └── relatorios/
│       ├── index.php (Página principal)
│       ├── dashboard.php (Dashboard executivo)
│       ├── movimentacoes.php (Relatório de movimentações)
│       ├── faturamento.php (Relatório de faturamento)
│       └── pdf/
│           ├── dashboard.php (Template PDF dashboard)
│           ├── movimentacoes.php (Template PDF movimentações)
│           └── faturamento.php (Template PDF faturamento)

public/
└── dist/
    ├── css/
    │   └── relatorios.css (Estilos específicos)
    └── js/
        ├── relatorios-dashboard.js (Scripts do dashboard)
        └── relatorios-faturamento.js (Scripts do faturamento)
```

## Consultas Principais no Model

### Estatísticas Gerais
- `get_total_vagas()`: Total de vagas disponíveis
- `get_vagas_ocupadas()`: Vagas atualmente ocupadas
- `get_faturamento_hoje()`: Faturamento do dia atual
- `get_movimentacoes_hoje()`: Movimentações do dia atual
- `get_taxa_ocupacao()`: Percentual de ocupação

### Dados para Gráficos
- `get_fluxo_diario($dias)`: Entradas por dia
- `get_ocupacao_por_categoria()`: Ocupação atual por categoria
- `get_faturamento_mensal($meses)`: Faturamento por mês
- `get_clientes_por_dia($dias)`: Clientes únicos por dia

### Relatórios Filtrados
- `get_movimentacoes_periodo($inicio, $fim)`: Movimentações por período
- `get_faturamento_periodo($inicio, $fim)`: Faturamento por período
- `get_faturamento_por_categoria($inicio, $fim)`: Faturamento por categoria

## Características dos Gráficos

### Interatividade
- Tooltips informativos
- Responsivos em dispositivos móveis
- Animações suaves
- Cores padronizadas do sistema

### Acessibilidade
- Contrastes adequados
- Labels descritivos
- Suporte a teclado
- Textos alternativos

## Personalizações Possíveis

### 1. Adicionar Novos Gráficos
```php
// No model
public function get_novo_grafico() {
    // Sua consulta SQL
}

// No controller
$data['novo_grafico'] = $this->relatorios_model->get_novo_grafico();

// Na view
// Adicionar canvas e script Chart.js
```

### 2. Novos Filtros
```php
// Adicionar campos no formulário
// Processar no controller
// Adaptar consultas no model
```

### 3. Novos Formatos de Exportação
```php
// Implementar novos métodos no controller
// Criar templates específicos
// Adicionar botões nas views
```

## Melhorias Futuras Sugeridas

1. **Cache de consultas** para melhor performance
2. **Agendamento de relatórios** via email
3. **Dashboard em tempo real** com WebSocket
4. **Exportação para Excel** além de PDF
5. **Relatórios comparativos** entre períodos
6. **Alertas automáticos** baseados em métricas
7. **API REST** para integração externa

## Notas Técnicas

- Todas as consultas usam prepared statements para segurança
- Os gráficos são gerados no frontend para melhor performance
- PDFs são gerados server-side para garantir formatação
- Sistema totalmente responsivo
- Compatível com impressão
- Otimizado para SEO e acessibilidade
