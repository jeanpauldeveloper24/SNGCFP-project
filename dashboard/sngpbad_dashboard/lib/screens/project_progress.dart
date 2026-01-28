import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class ProjectProgress extends StatefulWidget {
  const ProjectProgress({super.key});

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
          
          // Liste des projets avec barres de progression
          _buildProjectCard(
            "Construction du Pont de Cocody",
            "Abidjan, Côte d'Ivoire",
            0.85, // 85% physique
            0.70, // 70% financier
          ),
          _buildProjectCard(
            "Électrification zone Nord",
            "Korhogo / Odienné",
            0.45, 
            0.55, // Attention : plus payé que construit !
          ),
          _buildProjectCard(
            "Aménagement Route San-Pédro",
            "Axe Sud-Ouest",
            0.15, 
            0.10, 
          ),
        ],
      ),
    );
  }

  Widget _buildProjectCard(String title, String location, double physical, double financial) {
    return Container(
      margin: const EdgeInsets.only(bottom: 20),
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)
        ],
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title, style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 16)),
                  Text(location, style: GoogleFonts.inter(color: Colors.grey, fontSize: 12)),
                ],
              ),
              Icon(Icons.more_vert, color: Colors.grey[400]),
            ],
          ),
          const SizedBox(height: 20),
          
          // Barre Physique
          _buildProgressBar("Avancement Physique", physical, badGreen),
          const SizedBox(height: 15),
          
          // Barre Financière
          _buildProgressBar("Consommation Budgétaire", financial, Colors.blue),
        ],
      ),
    );
  }

  Widget _buildProgressBar(String label, double value, Color color) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(label, style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.w500)),
            Text("${(value * 100).toInt()}%", style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.bold, color: color)),
          ],
        ),
        const SizedBox(height: 8),
        ClipRRect(
          borderRadius: BorderRadius.circular(10),
          child: LinearProgressIndicator(
            value: value,
            backgroundColor: color.withOpacity(0.1),
            color: color,
            minHeight: 8,
          ),
        ),
      ],
    );
  }
}