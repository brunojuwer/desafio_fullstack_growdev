export function cpfFormatter(cpf: string): string {
  return cpf
    .replace(/\D/g, '')
    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona um ponto após os três primeiros dígitos
    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona um ponto após os próximos três dígitos
    .replace(/(\d{3})(\d{1,2})/, '$1-$2') // Adiciona um traço antes dos dois últimos dígitos
    .replace(/(-\d{2})\d+?$/, '$1'); // Limita o número de dígitos depois do traço
}
