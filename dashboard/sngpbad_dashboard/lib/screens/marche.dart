import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/datas/marche.dart';
import 'package:sngpbad_dashboard/screens/marche_form.dart';
import 'package:sngpbad_dashboard/services/marche_service.dart';



class Marche extends StatefulWidget {
  const Marche({super.key});

  @override
  State<Marche> createState() => _MarcheState();
}

class _MarcheState extends State<Marche> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color sngpGreen = const Color(0xFF27AE60);
  
  final MarcheService _marcheService = MarcheService();
  List<MarcheData> allMarches = [];
  List<MarcheData> filteredMarches = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadMarches();
  }

  Future<void> _loadMarches() async {
    setState(() => isLoading = true);
    try {
      final data = await _marcheService.fetchMarches();
      setState(() {
        allMarches = data.map((item) {
          bool conforme = item['is_conforme'] == 1 || item['is_conforme'] == true;
          return MarcheData(
            ref: item['ref'] ?? 'N/A',
            objet: item['objet'] ?? 'Sans objet',
            procedure: item['procedure'] ?? 'AOI',
            stade: item['stade'] ?? 'En attente',
            isConforme: conforme,
            color: conforme ? sngpGreen : Colors.orange,
          );
        }).toList();
        filteredMarches = allMarches;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      print("Erreur chargement marchés: $e");
    }
  }

  void _filterMarches(String query) {
    setState(() {
      filteredMarches = allMarches
          .where((m) => m.objet.toLowerCase().contains(query.toLowerCase()) || 
                         m.ref.toLowerCase().contains(query.toLowerCase()))
          .toList();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () => _showMarcheForm(context),
        backgroundColor: sngpGreen,
        icon: const Icon(Icons.send_rounded, color: Colors.white),
        label: const Text("Soumettre pour Vérification", style: TextStyle(color: Colors.white)),
      ),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 20),
            _buildSearchBar(),
            const SizedBox(height: 20),
            isLoading ? const LinearProgressIndicator() : _buildStatsRow(),
            const SizedBox(height: 20),
            Expanded(
              child: isLoading 
                ? const Center(child: CircularProgressIndicator())
                : _buildMarchesTable(),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSearchBar() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 15),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(10),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 5)],
      ),
      child: TextField(
        onChanged: _filterMarches,
        decoration: const InputDecoration(
          hintText: "Rechercher un dossier (Réf ou Objet)...",
          border: InputBorder.none,
          icon: Icon(Icons.search, color: Colors.grey),
        ),
      ),
    );
  }

  Widget _buildMarchesTable() {
    if (filteredMarches.isEmpty) {
      return const Center(child: Text("Aucun marché trouvé."));
    }
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
      child: SingleChildScrollView(
        scrollDirection: Axis.vertical,
        child: DataTable(
          headingRowColor: WidgetStateProperty.all(primaryBlue.withOpacity(0.05)),
          columns: const [
            DataColumn(label: Text('N° Dossier')),
            DataColumn(label: Text('Objet')),
            DataColumn(label: Text('Conformité')),
            DataColumn(label: Text('Statut')),
            DataColumn(label: Text('Actions')),
          ],
          rows: filteredMarches.map((m) => _buildDataRow(m)).toList(),
        ),
      ),
    );
  }

  DataRow _buildDataRow(MarcheData marche) {
    return DataRow(cells: [
      DataCell(Text(marche.ref, style: const TextStyle(fontWeight: FontWeight.bold))),
      DataCell(Text(marche.objet)),
      DataCell(Icon(
        marche.isConforme ? Icons.check_circle : Icons.hourglass_empty,
        color: marche.isConforme ? sngpGreen : Colors.orange,
        size: 20,
      )),
      DataCell(Container(
        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
        decoration: BoxDecoration(color: marche.color.withOpacity(0.1), borderRadius: BorderRadius.circular(20)),
        child: Text(marche.stade, style: TextStyle(color: marche.color, fontSize: 11, fontWeight: FontWeight.bold)),
      )),
      DataCell(IconButton(icon: const Icon(Icons.chat_outlined, color: Colors.blue), onPressed: () {})),
    ]);
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("Pilotage des Marchés", style: GoogleFonts.montserrat(fontSize: 24, fontWeight: FontWeight.bold, color: primaryBlue)),
        const Text("Suivi des dossiers et conformité aux normes BAD", style: TextStyle(color: Colors.grey, fontSize: 13)),
      ],
    );
  }

  Widget _buildStatsRow() {
    int attente = allMarches.where((m) => !m.isConforme).length;
    int valides = allMarches.where((m) => m.isConforme).length;

    return Row(
      children: [
        _buildStatCard("En attente", "$attente", Icons.pending_actions, Colors.orange),
        const SizedBox(width: 20),
        _buildStatCard("Validés Normes BAD", "$valides", Icons.verified_user, sngpGreen),
      ],
    );
  }

  Widget _buildStatCard(String title, String value, IconData icon, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(15),
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border(left: BorderSide(color: color, width: 4))),
        child: Row(
          children: [
            Icon(icon, color: color, size: 24),
            const SizedBox(width: 15),
            Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              Text(title, style: const TextStyle(color: Colors.grey, fontSize: 10, fontWeight: FontWeight.bold)),
              Text(value, style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
            ])
          ],
        ),
      ),
    );
  }

  void _showMarcheForm(BuildContext context) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => MarcheForm(onSaved: (objet, procedure) async {
        bool success = await _marcheService.saveMarche(objet, procedure);
        if (success) _loadMarches();
      }),
    );
  }
}