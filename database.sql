DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `UltimaAtualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE `subcategoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ID_Categoria` int DEFAULT NULL,
  `UltimaAtualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_subcategoria_categoria` (`ID_Categoria`),
  CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `servico`;
CREATE TABLE `servico` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ID_SubCategoria` int DEFAULT NULL,
  `KBs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `UltimaAtualizacao` datetime DEFAULT NULL,
  `area_especialista` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_responsavel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alcadas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `procedimento_excecao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `usuario_criador` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_ficha` enum('rascunho','em_revisao','revisada','em_aprovacao','aprovada','publicado','cancelada','reprovado_revisor','reprovado_po','substituida','descontinuada') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_revisao` datetime DEFAULT NULL,
  `po_aprovador_nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_aprovador_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_aprovacao` datetime DEFAULT NULL,
  `justificativa_rejeicao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `codigo_ficha` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versao` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  PRIMARY KEY (`ID`),
  KEY `fk_servico_subcategoria` (`ID_SubCategoria`),
  CONSTRAINT `fk_servico_subcategoria` FOREIGN KEY (`ID_SubCategoria`) REFERENCES `subcategoria` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `checklist`;
CREATE TABLE `checklist` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Servico` int DEFAULT NULL,
  `NomeItem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Observacao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID`),
  KEY `fk_checklist_servico` (`ID_Servico`),
  CONSTRAINT `fk_checklist_servico` FOREIGN KEY (`ID_Servico`) REFERENCES `servico` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `diretriz`;
CREATE TABLE `diretriz` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Servico` int DEFAULT NULL,
  `Titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_diretriz_servico` (`ID_Servico`),
  CONSTRAINT `fk_diretriz_servico` FOREIGN KEY (`ID_Servico`) REFERENCES `servico` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `itemdiretriz`;
CREATE TABLE `itemdiretriz` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Diretriz` int DEFAULT NULL,
  `Conteudo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID`),
  KEY `fk_itemdiretriz_diretriz` (`ID_Diretriz`),
  CONSTRAINT `fk_itemdiretriz_diretriz` FOREIGN KEY (`ID_Diretriz`) REFERENCES `diretriz` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `padrao`;
CREATE TABLE `padrao` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Servico` int DEFAULT NULL,
  `Titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_padrao_servico` (`ID_Servico`),
  CONSTRAINT `fk_padrao_servico` FOREIGN KEY (`ID_Servico`) REFERENCES `servico` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `itempadrao`;
CREATE TABLE `itempadrao` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Padrao` int DEFAULT NULL,
  `Conteudo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID`),
  KEY `fk_itempadrao_padrao` (`ID_Padrao`),
  CONSTRAINT `fk_itempadrao_padrao` FOREIGN KEY (`ID_Padrao`) REFERENCES `padrao` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pos`;
CREATE TABLE `pos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `revisores`;
CREATE TABLE `revisores` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `servico_revisores`;
CREATE TABLE `servico_revisores` (
  `servico_id` int NOT NULL,
  `revisor_id` int NOT NULL,
  PRIMARY KEY (`servico_id`,`revisor_id`),
  KEY `revisor_id` (`revisor_id`),
  CONSTRAINT `servico_revisores_ibfk_1` FOREIGN KEY (`servico_id`) REFERENCES `servico` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `servico_revisores_ibfk_2` FOREIGN KEY (`revisor_id`) REFERENCES `revisores` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `sugestoes`;
CREATE TABLE sugestoes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    servico_id INT NOT NULL,
    texto_sugestao TEXT NOT NULL,
    autor_sugestao VARCHAR(255) NOT NULL,
    data_sugestao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Nova',
    FOREIGN KEY (servico_id) REFERENCES servico(ID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

