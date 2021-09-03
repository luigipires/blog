-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Set-2021 às 23:51
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_gestao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `conteudo` longtext NOT NULL,
  `foto_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `nome_usuario`, `conteudo`, `foto_usuario`) VALUES
(2, 'Paulo Rodrigues', 'Sadsadsasadadsasd', '6039939fb652a.png'),
(3, 'Jorge Abraão', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam massa urna, bibendum nec nibh non, pulvinar luctus nisi. Nunc quis euismod justo, vulputate consectetur dolor. Suspendisse molestie, lacus hendrerit sodales eleifend, justo nibh consequat lacus, in dictum ex est sit amet arcu. Integer purus tortor, imperdiet sit amet dui et, condimentum tempus arcu. Curabitur nec aliquet neque. Donec tempus turpis enim, vitae mattis odio scelerisque ac. Integer id sodales nunc. Curabitur rutrum lorem id iaculis venenatis.', '0'),
(4, 'Luana de Sikeira', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '6079c6beef463.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `titulo_banner` varchar(255) NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `banners`
--

INSERT INTO `banners` (`id`, `titulo_banner`, `ativo`) VALUES
(13, 'Floral', 0),
(14, 'Novo álbum', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias_noticia`
--

CREATE TABLE `categorias_noticia` (
  `id` int(11) NOT NULL,
  `nome_categoria` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias_noticia`
--

INSERT INTO `categorias_noticia` (`id`, `nome_categoria`, `descricao`, `url`) VALUES
(1, 'marketing digital', 'Devem ser inseridos todos os conteúdos referentes a marketing digital', 'marketing-digital'),
(2, 'Esportes', 'Todas as notícias referentes aos esportes ', 'esportes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `comentario` longtext NOT NULL,
  `comentario_like` int(11) NOT NULL,
  `comentario_deslike` int(11) NOT NULL,
  `denuncia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `usuario_id`, `noticia_id`, `comentario`, `comentario_like`, `comentario_deslike`, `denuncia`) VALUES
(1, 9, 16, 'OI', 1, 1, 20),
(2, 9, 16, 'asddsa', 1, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comunicacao_suporte`
--

CREATE TABLE `comunicacao_suporte` (
  `id` int(11) NOT NULL,
  `token_usuario` varchar(255) NOT NULL,
  `resposta` longtext NOT NULL,
  `identificacao_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comunicacao_suporte`
--

INSERT INTO `comunicacao_suporte` (`id`, `token_usuario`, `resposta`, `identificacao_usuario`) VALUES
(1, '603a9c1c4dca9', 'Acho que você já está testando', 1),
(2, '603a9c1c4dca9', 'Eu acho que não', -1),
(3, '603a9c1c4dca9', 'Não é não', 1),
(4, '603a9c1c4dca9', 'mano, não trolla pfv', -1),
(5, '603a9c1c4dca9', 'para com isso mano, senão vou fechar essa porra aqui', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_usuario`
--

CREATE TABLE `denuncia_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `resposta_id` int(11) NOT NULL,
  `acao_denuncia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedback_comentarios`
--

CREATE TABLE `feedback_comentarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `comentario_like` int(11) NOT NULL,
  `comentario_deslike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `feedback_comentarios`
--

INSERT INTO `feedback_comentarios` (`id`, `usuario_id`, `noticia_id`, `comentario_id`, `comentario_like`, `comentario_deslike`) VALUES
(2, 9, 16, 1, 1, 0),
(3, 10, 16, 1, 0, 1),
(4, 10, 16, 2, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedback_respostas`
--

CREATE TABLE `feedback_respostas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `resposta_id` int(11) NOT NULL,
  `comentario_like` int(11) NOT NULL,
  `comentario_deslike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `feedback_respostas`
--

INSERT INTO `feedback_respostas` (`id`, `usuario_id`, `noticia_id`, `comentario_id`, `resposta_id`, `comentario_like`, `comentario_deslike`) VALUES
(5, 9, 16, 1, 7, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens_banners`
--

CREATE TABLE `imagens_banners` (
  `id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `foto_banner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `imagens_banners`
--

INSERT INTO `imagens_banners` (`id`, `banner_id`, `foto_banner`) VALUES
(35, 13, '613282b8650fb.jpg'),
(36, 13, '613282b865283.jpg'),
(37, 13, '613282b8653d8.jpg'),
(38, 14, '613282ccb59b3.png'),
(39, 14, '613282ccb5bd7.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens_noticias`
--

CREATE TABLE `imagens_noticias` (
  `id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `foto_noticia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `imagens_noticias`
--

INSERT INTO `imagens_noticias` (`id`, `noticia_id`, `foto_noticia`) VALUES
(36, 15, '613293614304d.jpg'),
(37, 15, '61329361432aa.jpg'),
(38, 16, '613294890f9f0.jpg'),
(39, 16, '613294890fbea.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` longtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `categoria_id`, `titulo`, `conteudo`, `url`, `views`) VALUES
(15, 1, 'Passo a passo de como ganhar dinheiro na internet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel massa pellentesque, ornare ligula a, elementum urna. Sed congue ex in elementum ultricies. Curabitur non lobortis neque, id interdum velit. Vestibulum et ultrices orci. Quisque a pellentesque nulla. Maecenas non metus nec erat pellentesque venenatis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam quis ipsum nec sapien aliquet sagittis. Pellentesque sed ipsum nisi. Fusce felis purus, elementum commodo risus vel, malesuada rutrum nulla. Sed sollicitudin sit amet lacus eget suscipit. Morbi rhoncus elementum lorem eget semper. Aliquam placerat ligula sed sapien laoreet, ut semper nisi porta. Vivamus id velit purus. Maecenas eget velit et nulla vulputate iaculis ac cursus diam. Donec quis elit tortor.\r\n\r\nCurabitur faucibus risus quis aliquam convallis. Maecenas vel blandit tellus. Fusce ut ornare velit, sed commodo augue. Pellentesque luctus mi sit amet dui sodales semper. Proin laoreet quam neque, a mattis ipsum sagittis vel. Mauris varius ex justo, quis porta urna efficitur ut. Nulla facilisi. Vivamus vel viverra dui, non consectetur orci. In feugiat posuere elit in feugiat. Donec egestas, mi quis elementum tristique, augue purus consequat velit, non cursus tellus nisl in quam.', 'passo-a-passo-de-como-ganhar-dinheiro-na-internet', 3),
(16, 2, 'Grêmio perde o primeiro jogo da final da copa do brasil', 'Numa partida de pouca técnica e muito suor, o Grêmio perdeu para o Palmeiras, por 1 a 0, no jogo de ida da final da Copa do Brasil, na noite deste domingo, na Arena. Agora, o Tricolor precisará vencer no Allianz Parque, no próximo domingo, dia 7, para conquistar o hexacampeonato da Copa do Brasil. Sem gol qualificado, qualquer vitória gremista por 1 a 0 leva a decisão para os pênaltis e uma vantagem de dois gols sela a conquista. \r\n\r\nCom uma proposta defensiva, o Palmeiras controlou boa parte da partida e marcou o gol com Gustavo Goméz, depois de falha defensiva gremista aos 31 minutos do primeiro tempo.\r\n\r\nNa volta do intervalo, o zagueiro palmeirense Luan foi expulso e a equipe de Renato Portaluppi, com a entrada de Ferreira, passou a pressionar, mas sem sucesso e organização. Sem muito repertório, o Tricolor apostou nas bolas pelo alto e travou na boa defesa adversária.  ', 'gremio-perde-o-primeiro-jogo-da-final-da-copa-do-brasil', 210);

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `comentario_id` int(11) NOT NULL,
  `resposta_id` int(11) NOT NULL,
  `resposta` longtext NOT NULL,
  `comentario_like` int(11) NOT NULL,
  `comentario_deslike` int(11) NOT NULL,
  `denuncia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `usuario_id`, `noticia_id`, `comentario_id`, `resposta_id`, `resposta`, `comentario_like`, `comentario_deslike`, `denuncia`) VALUES
(1, 9, 16, 1, 0, 'olá', 0, 0, 0),
(7, 10, 16, 1, 1, 'oi', 1, 0, 6),
(8, 9, 16, 2, 0, 'ds', 0, 0, 2),
(9, 9, 16, 2, 8, 'sim', 0, 0, 1),
(10, 9, 16, 2, 8, 'sadsadsa', 0, 0, 0),
(11, 9, 16, 2, 8, 'ssdaa', 0, 0, 2),
(12, 9, 16, 1, 1, 'sdadas', 0, 0, 3),
(13, 9, 16, 2, 8, '@Maria eu disse que era assim', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `suporte`
--

CREATE TABLE `suporte` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pergunta` varchar(255) NOT NULL,
  `explicacao` longtext NOT NULL,
  `token` varchar(255) NOT NULL,
  `status_andamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `suporte`
--

INSERT INTO `suporte` (`id`, `usuario_id`, `pergunta`, `explicacao`, `token`, `status_andamento`) VALUES
(1, 9, 'Como testar o suporte?', 'Era só isso mesmo', '603a9c1c4dca9', 0),
(2, 10, 'Não consigo redefinir a senha', 'Acesso a opção disponível para mudar minha senha, mas a mesma não encontra meu e-mail. O que eu faço?', '603d2fec48f9c', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto_usuario` varchar(255) NOT NULL,
  `tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `email`, `senha`, `foto_usuario`, `tipo_usuario`) VALUES
(9, 'Maria', 'Luiza', 'maria@gmail.com', '336eb886869f879f72e5ff6f470d6958', '6132952c413db.jpg', 2),
(10, 'Paulo', 'Rodrigues', 'paulorodrigues@hotmail.com', 'c7021c6ff704e3f9b436a4ce6a38a008', '0', 0),
(11, 'Ricardo ', 'Vasconcellos', 'ricardao666@yahoo.com.br', '1c7a2b65b487a165a738bea781a51b0e', '0', 1),
(12, 'sadasd', 'sadasds', 'lucas2222@gmail.com', 'c78d2c80a016875f3b6e71f01c093a73', '0', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categorias_noticia`
--
ALTER TABLE `categorias_noticia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comunicacao_suporte`
--
ALTER TABLE `comunicacao_suporte`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `denuncia_usuario`
--
ALTER TABLE `denuncia_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `feedback_comentarios`
--
ALTER TABLE `feedback_comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `feedback_respostas`
--
ALTER TABLE `feedback_respostas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `imagens_banners`
--
ALTER TABLE `imagens_banners`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `imagens_noticias`
--
ALTER TABLE `imagens_noticias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `suporte`
--
ALTER TABLE `suporte`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `categorias_noticia`
--
ALTER TABLE `categorias_noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `comunicacao_suporte`
--
ALTER TABLE `comunicacao_suporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `denuncia_usuario`
--
ALTER TABLE `denuncia_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `feedback_comentarios`
--
ALTER TABLE `feedback_comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `feedback_respostas`
--
ALTER TABLE `feedback_respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `imagens_banners`
--
ALTER TABLE `imagens_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `imagens_noticias`
--
ALTER TABLE `imagens_noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `suporte`
--
ALTER TABLE `suporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
