class ProjectModel {
  final int id;
  final String code;
  final String nom;
  final String categorie;
  final double budgetAlloue;
  final double budgetDepense;
  final double tauxExecution;

  ProjectModel({
    required this.id,
    required this.code,
    required this.nom,
    required this.categorie,
    required this.budgetAlloue,
    required this.budgetDepense,
    required this.tauxExecution,
  });

  factory ProjectModel.fromJson(Map<String, dynamic> json) {
    return ProjectModel(
      id: json['id'],
      code: json['code'],
      nom: json['nom'],
      categorie: json['categorie'],
      // Conversion sécurisée en double (car Laravel peut envoyer des int ou string)
      budgetAlloue: double.parse(json['budget_alloue'].toString()),
      budgetDepense: double.parse(json['budget_depense'].toString()),
      tauxExecution: double.parse(json['taux_execution'].toString()),
    );
  }
}