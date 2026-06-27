import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class ProjectListScreen extends StatefulWidget {
  const ProjectListScreen({super.key});

  @override
  State<ProjectListScreen> createState() => _ProjectListScreenState();
}

class _ProjectListScreenState extends State<ProjectListScreen> {
  // Simulation de données basée sur ton schéma Firebase/BD
  final List<Map<String, dynamic>> _projects = [
    {
      "name": "SNGCFP-project",
      "description": "Système National de Gestion de la Conformité des Financements de Projets auprès de la BAD.",
      "budget": "450 000 000",
      "montant_decaisse": "150 000 000",
      "montant_reste": "300 000 000",
      "population_impact": "250 000",
      "responsable": "Kouassi Yao Jean Paul",
      "start_date": "01/01/2026",
      "end_date": "31/12/2028",
      "modules_count": 5,
    },
    {
      "name": "Aménagement Routier Zone Est",
      "description": "Bitumage et ouverture des voies secondaires de désenclavement agricole.",
      "budget": "1 200 000 000",
      "montant_decaisse": "900 000 000",
      "montant_reste": "300 000 000",
      "population_impact": "1 500 000",
      "responsable": "Direction des Infrastructures",
      "start_date": "15/03/2025",
      "end_date": "20/08/2027",
      "modules_count": 8,
    }
  ];

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color textDark = const Color(0xFF1E1E2D);

  @override
  Widget build(BuildContext context) {
    // Calcul de la disposition responsive pour écran Desktop / Tablette
    double width = MediaQuery.of(context).size.width;
    int crossAxisCount = width > 1200 ? 3 : (width > 800 ? 2 : 1);

    return Scaffold(
      backgroundColor: const Color(0xFFF4F6F9),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 24),
            _buildSearchBar(),
            const SizedBox(height: 24),
            Expanded(
              child: _projects.isEmpty
                  ? _buildEmptyState()
                  : GridView.builder(
                      itemCount: _projects.length,
                      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: crossAxisCount,
                        crossAxisSpacing: 16,
                        mainAxisSpacing: 16,
                        mainAxisExtent: 310, // Hauteur fixe pour éviter les débordements
                      ),
                      itemBuilder: (context, index) {
                        final project = _projects[index];
                        return _buildProjectCard(project);
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }

  // En-tête de la page
  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Portefeuille des Projets",
          style: GoogleFonts.montserrat(
            fontSize: 26,
            fontWeight: FontWeight.bold,
            color: textDark,
          ),
        ),
        const SizedBox(height: 4),
        Text(
          "Suivi global, financier et opérationnel des investissements",
          style: GoogleFonts.inter(fontSize: 13, color: Colors.grey[600]),
        ),
      ],
    );
  }

  // Barre de recherche épurée
  Widget _buildSearchBar() {
    return Row(
      children: [
        Expanded(
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(8),
              boxShadow: const [BoxShadow(color: Colors.black12, blurRadius: 4, offset: Offset(0, 2))],
            ),
            child: TextField(
              decoration: InputDecoration(
                hintText: "Rechercher un projet, un responsable...",
                hintStyle: GoogleFonts.inter(fontSize: 13, color: Colors.grey),
                prefixIcon: Icon(Icons.search, color: primaryBlue),
                border: InputBorder.none,
                contentPadding: const EdgeInsets.symmetric(vertical: 14),
              ),
            ),
          ),
        ),
        const SizedBox(width: 16),
        ElevatedButton.icon(
          onPressed: () {},
          icon: const Icon(Icons.filter_list, size: 18),
          label: const Text("Filtrer"),
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.white,
            foregroundColor: primaryBlue,
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(8),
              side: BorderSide(color: primaryBlue.withOpacity(0.2)),
            ),
          ),
        )
      ],
    );
  }

  // Composant Carte Projet (Optimisé pour afficher ton modèle de données)
  Widget _buildProjectCard(Map<String, dynamic> project) {
    // Calcul automatique du pourcentage de décaissement pour l'UI
    double budgetRaw = double.tryParse(project["budget"].replaceAll(' ', '')) ?? 1;
    double decaisseRaw = double.tryParse(project["montant_decaisse"].replaceAll(' ', '')) ?? 0;
    double progress = (decaisseRaw / budgetRaw).clamp(0.0, 1.0);

    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.03), blurRadius: 10, offset: const Offset(0, 4))
        ],
        border: Border.all(color: Colors.grey.withOpacity(0.1)),
      ),
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Titre & Badge Modules
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: Text(
                  project["name"],
                  style: GoogleFonts.montserrat(fontSize: 16, fontWeight: FontWeight.bold, color: textDark),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: primaryBlue.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(6),
                ),
                child: Text(
                  "${project["modules_count"]} Modules",
                  style: GoogleFonts.inter(color: primaryBlue, fontSize: 11, fontWeight: FontWeight.bold),
                ),
              ),
            ],
          ),
          const SizedBox(height: 8),
          // Description
          Text(
            project["description"],
            style: GoogleFonts.inter(fontSize: 12, color: Colors.grey[600], height: 1.4),
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
          ),
          const Spacer(),
          const Divider(height: 20, color: Colors.black12),
          // Indicateurs financiers (Mise en avant de tes variables BD)
          _buildCardFinancialRow("Budget Global:", "${project["budget"]} FCFA", isBold: true),
          const SizedBox(height: 4),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              _buildAmountSubBlock("Décaissé", "${project["montant_decaisse"]} F", Colors.green),
              _buildAmountSubBlock("Reste", "${project["montant_reste"]} F", Colors.orange),
            ],
          ),
          const SizedBox(height: 8),
          // Barre visuelle de progression financière
          LinearProgressIndicator(
            value: progress,
            backgroundColor: Colors.grey[200],
            color: primaryBlue,
            minHeight: 5,
          ),
          const Spacer(),
          // Pied de carte : Impact & Actions
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Row(
                children: [
                  const Icon(Icons.people_outline, size: 16, color: Colors.grey),
                  const SizedBox(width: 4),
                  Text(
                    "${project["population_impact"]} impactés",
                    style: GoogleFonts.inter(fontSize: 11, color: Colors.grey[600], fontWeight: FontWeight.w500),
                  ),
                ],
              ),
              TextButton.icon(
                onPressed: () {
                  // Action pour ouvrir la fiche détaillée (Composantes, Activités, GED...)
                },
                icon: const Icon(Icons.arrow_forward, size: 14),
                label: const Text("Détails"),
                style: TextButton.styleFrom(
                  foregroundColor: primaryBlue,
                  textStyle: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.bold),
                ),
              )
            ],
          )
        ],
      ),
    );
  }

  Widget _buildCardFinancialRow(String label, String value, {bool isBold = false}) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(label, style: GoogleFonts.inter(fontSize: 12, color: Colors.grey[600])),
        Text(
          value,
          style: GoogleFonts.inter(
            fontSize: 12,
            fontWeight: isBold ? FontWeight.bold : FontWeight.normal,
            color: textDark,
          ),
        ),
      ],
    );
  }

  Widget _buildAmountSubBlock(String label, String amount, Color color) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label, style: GoogleFonts.inter(fontSize: 10, color: Colors.grey)),
        Text(
          amount,
          style: GoogleFonts.inter(fontSize: 12, fontWeight: FontWeight.bold, color: color),
        ),
      ],
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.folder_open_outlined, size: 64, color: Colors.grey[400]),
          const SizedBox(height: 16),
          Text(
            "Aucun projet enregistré",
            style: GoogleFonts.montserrat(fontSize: 16, fontWeight: FontWeight.bold, color: textDark),
          ),
        ],
      ),
    );
  }
}