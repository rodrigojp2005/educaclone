# Clone do Udemy - Laravel 10

Um clone completo da plataforma Udemy desenvolvido com Laravel 10, PHP 8.1 e MySQL.

## 🚀 Funcionalidades

### Sistema de Usuários
- ✅ Autenticação completa (login, registro, recuperação de senha)
- ✅ Três tipos de usuários: Admin, Instrutor e Estudante
- ✅ Perfis de usuário com informações adicionais
- ✅ Sistema de roles e permissões

### Sistema de Cursos
- ✅ CRUD completo de cursos
- ✅ Categorias organizadas com ícones e cores
- ✅ Níveis de dificuldade (Iniciante, Intermediário, Avançado)
- ✅ Preços e descontos
- ✅ Cursos gratuitos e pagos
- ✅ Sistema de destaque

### Sistema de Aulas
- ✅ Múltiplos tipos de conteúdo (vídeo, texto, quiz, arquivo)
- ✅ Controle de progresso por aula
- ✅ Sistema de conclusão automática
- ✅ Tracking de tempo assistido

### Sistema de Matrículas
- ✅ Matrículas em cursos
- ✅ Controle de progresso geral
- ✅ Data de conclusão
- ✅ Certificados (estrutura preparada)

### Sistema de Avaliações
- ✅ Avaliações com estrelas (1-5)
- ✅ Comentários dos estudantes
- ✅ Sistema de aprovação
- ✅ Análise de sentimento

### Painel Administrativo
- ✅ Dashboard com estatísticas
- ✅ Gerenciamento de usuários
- ✅ Gerenciamento de cursos
- ✅ Gerenciamento de categorias
- ✅ Interface responsiva

### Frontend Público
- ✅ Página inicial moderna
- ✅ Listagem de cursos por categoria
- ✅ Sistema de busca
- ✅ Design responsivo
- ✅ Interface inspirada no Udemy

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 10, PHP 8.1
- **Banco de Dados**: MySQL 8.0
- **Frontend**: Blade Templates, Bootstrap 5
- **Autenticação**: Laravel Breeze
- **Ícones**: Font Awesome 6
- **Estilização**: CSS customizado

## 📦 Instalação

### Pré-requisitos
- PHP 8.1 ou superior
- Composer
- MySQL 8.0
- Node.js (para assets)

### Passos de Instalação

1. **Clone o repositório**
```bash
git clone <url-do-repositorio>
cd udemy-clone
```

2. **Instale as dependências**
```bash
composer install
npm install
```

3. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure o banco de dados**
Edite o arquivo `.env` com suas credenciais do MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=udemy_clone
DB_USERNAME=udemy_user
DB_PASSWORD=udemy_password
```

5. **Execute as migrations e seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Compile os assets**
```bash
npm run build
```

7. **Inicie o servidor**
```bash
php artisan serve
```

## 👥 Usuários de Teste

O sistema vem com usuários pré-configurados para teste:

### Administrador
- **Email**: admin@udemyclone.com
- **Senha**: password
- **Acesso**: Painel administrativo completo

### Instrutor
- **Email**: instrutor@udemyclone.com
- **Senha**: password
- **Acesso**: Criação e gerenciamento de cursos

### Estudante
- **Email**: estudante@udemyclone.com
- **Senha**: password
- **Acesso**: Matrícula em cursos e acompanhamento de progresso

## 📊 Estrutura do Banco de Dados

### Tabelas Principais
- `users` - Usuários do sistema
- `categories` - Categorias de cursos
- `courses` - Cursos disponíveis
- `lessons` - Aulas dos cursos
- `enrollments` - Matrículas dos estudantes
- `lesson_progress` - Progresso nas aulas
- `reviews` - Avaliações dos cursos

### Relacionamentos
- Um usuário pode ter muitos cursos (como instrutor)
- Um curso pertence a uma categoria
- Um curso tem muitas aulas
- Um usuário pode se matricular em muitos cursos
- Cada matrícula tem progresso em múltiplas aulas

## 🎨 Design e Interface

### Cores do Sistema
- **Primária**: #a435f0 (Roxo Udemy)
- **Secundária**: #5624d0 (Roxo escuro)
- **Sucesso**: #73bc00 (Verde)
- **Aviso**: #f69c08 (Laranja)
- **Perigo**: #e74c3c (Vermelho)

### Componentes
- Cards de cursos responsivos
- Sistema de avaliação com estrelas
- Badges para categorias e níveis
- Botões com hover effects
- Layout responsivo para mobile

## 🔧 Funcionalidades Técnicas

### Middleware Personalizado
- `CheckRole`: Controla acesso baseado em roles

### Scopes do Eloquent
- `published()`: Filtra cursos publicados
- `featured()`: Filtra cursos em destaque
- `byLevel()`: Filtra por nível de dificuldade

### Relacionamentos Eloquent
- Relacionamentos polimórficos preparados
- Eager loading otimizado
- Contadores de relacionamentos

### Seeders Inclusos
- Categorias com ícones e cores
- Cursos de exemplo
- Usuários de teste
- Aulas de exemplo
- Avaliações de exemplo

## 📱 Responsividade

O sistema é totalmente responsivo e funciona em:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (até 767px)

## 🚀 Próximos Passos

### Funcionalidades Planejadas
- [ ] Sistema de pagamentos (Stripe/PayPal)
- [ ] Chat entre instrutor e estudante
- [ ] Certificados em PDF
- [ ] Sistema de cupons de desconto
- [ ] API REST completa
- [ ] Aplicativo mobile
- [ ] Sistema de notificações
- [ ] Relatórios avançados

### Melhorias Técnicas
- [ ] Testes unitários e de integração
- [ ] Cache com Redis
- [ ] Filas para processamento
- [ ] Upload de vídeos para AWS S3
- [ ] CDN para assets
- [ ] Otimização de performance

## 📄 Licença

Este projeto é desenvolvido para fins educacionais e de demonstração.

## 🤝 Contribuição

Contribuições são bem-vindas! Por favor:

1. Faça um fork do projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📞 Suporte

Para dúvidas ou suporte, entre em contato através dos issues do GitHub.

---

**Desenvolvido com ❤️ usando Laravel 10**
