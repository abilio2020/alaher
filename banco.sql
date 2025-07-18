CREATE DATABASE gestao_vistos;
USE gestao_vistos;
CREATE TABLE vistos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_completo VARCHAR(255),
  passaporte VARCHAR(50),
  nacionalidade VARCHAR(100),
  tipo_visto VARCHAR(100),
  data_emissao DATE,
  data_expiracao DATE,
  status VARCHAR(50),
  observacao TEXT,
  paradeiro_passaporte VARCHAR(255),
  comentarios TEXT
);