import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../models/project_model.dart'; // Assure-toi d'avoir créé ce modèle

class ProjectProgress extends StatefulWidget {
  final List<ProjectModel> projects;

  const ProjectProgress({super.key, required this.projects});

  @override
  State<ProjectProgress> createState() => _ProjectProgressState();
}

class _ProjectProgressState extends State<ProjectProgress> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color badGreen = const Color(0xFF2ECC71);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Suivi de l'Avancement des Projets",
            style: GoogleFonts.montserrat(
              fontSize: 18, 
              fontWeight: FontWeight.bold, 
              color: primaryBlue
            ),
          ),
          const SizedBox(height: 25),
          
          // Gestion du cas où la liste est vide (chargement ou erreur)
          if (widget.projects.isEmpty)
            _buildEmptyState()
          else
            // Génération dynamique des cartes à partir de la DB
            ...widget.projects.map((project) {
              // Calcul du % financier : (Dépensé / Alloué)
              // On s'assure de ne pas diviser par zéro
              double financialProgress = project.budgetAlloue > 0 
                  ? (project.budgetDepense / project.budgetAlloue) 
                  : 0.0;
              
              // On convertit le taux d'exécution (souvent en %) en valeur 0.0 à 1.0
              double physicalProgress = project.tauxExecution > 1 
                  ? project.tauxExecution / 100 
                  : project.tauxExecution;

              return _buildProjectCard(
                project.nom,
                project.categorie, // Utilise la catégorie comme sous-titre
                physicalProgress, 
                financialProgress,
              );
            }).toList(),
        ],
      ),
    );
  }

  Widget _buildEmptyState() {
  return Center( // Le Center est le widget parent, pas une propriété
    child: Padding(
      padding: const EdgeInsets.all(40),
      child: Column(
        mainAxisSize: MainAxisSize.min, // Pour ne pas prendre tout l'écran
        children: [
          Icon(Icons.folder_open_outlined, size: 60, color: Colors.grey[400]),
          const SizedBox(height: 15),
          Text(
            "Aucun projet trouvé",
            style: GoogleFonts.inter(
              color: Colors.grey[600],
              fontSize: 16,
              fontWeight: FontWeight.w500
            ),
          ),
          Text(
            "Vérifiez la connexion avec le serveur Laravel",
            style: GoogleFonts.inter(color: Colors.grey[400], fontSize: 12),
          ),
        ],
      ),
    ),
  );
}

  Widget _buildProjectCard(String title, String subtitle, double physical, double financial) {
    return Container(
      margin: const EdgeInsets.only(bottom: 20),
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05), 
            blurRadius: 10,
            offset: const Offset(0, 4)
          )
        ],
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded( // Pour éviter les débordements de texte si le nom est long
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title, 
                      style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 16),
                      overflow: TextOverflow.ellipsis,
                    ),
                    Text(subtitle, style: GoogleFonts.inter(color: Colors.grey, fontSize: 12)),
                  ],
                ),
              ),
              const Icon(Icons.analytics_outlined, color: Color(0xFF1B4F72), size: 20),
            ],
          ),
          const SizedBox(height: 20),
          
          // Barre Physique (Vert SNGP/BAD)
          _buildProgressBar("Avancement Physique", physical, badGreen),
          const SizedBox(height: 15),
          
          // Barre Financière (Bleu institutionnel)
          _buildProgressBar("Consommation Budgétaire", financial, const Color(0xFF3498DB)),
        ],
      ),
    );
  }

  Widget _buildProgressBar(String label, double value, Color color) {
    // On bride la valeur entre 0.0 et 1.0 pour éviter les erreurs de LinearProgressIndicator
    final double safeValue = value.clamp(0.0, 1.0);

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(label, style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.w500)),
            Text(
              "${(safeValue * 100).toStringAsFixed(1)}%", 
              style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.bold, color: color)
            ),
          ],
        ),
        const SizedBox(height: 8),
        ClipRRect(
          borderRadius: BorderRadius.circular(10),
          child: LinearProgressIndicator(
            value: safeValue,
            backgroundColor: color.withOpacity(0.1),
            color: color,
            minHeight: 8,
          ),
        ),
      ],
    );
  }
}